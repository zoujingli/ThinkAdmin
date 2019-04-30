<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\store\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

/**
 * 商城数据处理指令
 * Class AutoRun
 * @package app\store\command
 */
class AutoRun extends Command
{

    protected function configure()
    {
        $this->setName('xclean:store')->setDescription('clean up invalid store records');
    }

    /**
     * 业务指令执行
     * @param Input $input
     * @param Output $output
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function execute(Input $input, Output $output)
    {
        // 自动取消30分钟未支付的订单
        $this->autoCancelOrder();
        // 清理一天前未支付的订单
        $this->autoCleanOrder();
        // 订单自动退款处理
        // $this->autoRefundOrder();
        // 提现自动打款处理
        // $this->autoTransfer();
    }

    /**
     * 自动取消30分钟未支付的订单
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function autoCancelOrder()
    {
        $where = [['create_at', '<', date('Y-m-d H:i:s', strtotime('-30 minutes'))]];
        $count = Db::name('StoreOrder')->where(['pay_state' => '0'])->whereIn('status', ['1', '2'])->where($where)->update([
            'status'       => '0',
            'cancel_state' => '1',
            'cancel_at'    => date('Y-m-d H:i:s'),
            'cancel_desc'  => '30分钟未完成支付自动取消订单',
        ]);
        if ($count > 0) {
            $this->output->info("共计自动取消了30分钟未支付的{$count}笔订单！");
        } else {
            $this->output->comment('没有需要自动取消30分钟未支付的订单记录！');
        }
    }

    /**
     * 清理一天前未支付的订单
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    private function autoCleanOrder()
    {
        $where = [['create_at', '<', date('Y-m-d H:i:s', strtotime('-1 day'))]];
        $list = Db::name('StoreOrder')->where(['pay_state' => '0'])->where($where)->limit(20)->select();
        if (count($order_nos = array_unique(array_column($list, 'order_no'))) > 0) {
            $this->output->info("自动删除前一天已经取消的订单：\n\t" . join(',' . PHP_EOL . "\t", $order_nos));
            Db::name('StoreOrder')->whereIn('order_no', $order_nos)->delete();
            Db::name('StoreOrderList')->whereIn('order_no', $order_nos)->delete();
        } else {
            $this->output->comment('没有需要自动删除前一天已经取消的订单！');
        }
    }

    /**
     * 订单自动退款操作
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    private function autoRefundOrder()
    {
        // 未完成退款的订单，执行微信退款操作
        foreach (Db::name('StoreOrder')->where(['refund_state' => '1'])->select() as $order) {
            try {
                $this->output->writeln("正在为 {$order['order_no']} 执行退款操作...");
                $result = \We::WePayRefund(config('wechat.wxpay'))->create([
                    'transaction_id' => $order['pay_no'],
                    'out_refund_no'  => $order['refund_no'],
                    'total_fee'      => $order['price_total'] * 100,
                    'refund_fee'     => $order['pay_price'] * 100,
                    'refund_account' => 'REFUND_SOURCE_UNSETTLED_FUNDS',
                ]);
                if ($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS') {
                    Db::name('StoreOrder')->where(['order_no' => $order['order_no']])->update([
                        'refund_state' => '2', 'refund_desc' => '自动退款成功！',
                    ]);
                } else {
                    Db::name('StoreOrder')->where(['order_no' => $order['order_no']])->update([
                        'refund_desc' => isset($result['err_code_des']) ? $result['err_code_des'] : '自动退款失败',
                    ]);
                }
            } catch (\Exception $e) {
                $this->output->writeln("订单 {$order['order_no']} 执行退款失败，{$e->getMessage()}！");
                Db::name('StoreOrder')->where(['order_no' => $order['order_no']])->update(['refund_desc' => $e->getMessage()]);
            }
        }
        $this->output->writeln('自动检测退款订单执行完成！');
    }

    /**
     * 自动企业打款操作
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    private function autoTransfer()
    {
        # 批量企业打款
        foreach (Db::name('StoreProfitUsed')->where(['status' => '1'])->select() as $vo) {
            try {
                $wechat = \We::WePayTransfers(config('wechat.wxpay'));
                $result = $wechat->create([
                    'partner_trade_no' => $vo['trs_no'],
                    'openid'           => $vo['openid'],
                    'check_name'       => 'NO_CHECK',
                    'amount'           => $vo['pay_price'] * 100,
                    'desc'             => '营销活动拥金提现',
                    'spbill_create_ip' => '127.0.0.1',
                ]);
                if ($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS') {
                    Db::name('StoreProfitUsed')->where(['trs_no' => $vo['trs_no']])->update([
                        'status' => '2', 'pay_desc' => '拥金提现成功！', 'pay_no' => $result['payment_no'], 'pay_at' => date('Y-m-d H:i:s'),
                    ]);
                } else {
                    Db::name('StoreProfitUsed')->where(['trs_no' => $vo['trs_no']])->update([
                        'pay_desc' => isset($result['err_code_des']) ? $result['err_code_des'] : '自动打款失败', 'last_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            } catch (\Exception $e) {
                $this->output->writeln("订单 {$vo['trs_no']} 执行提现失败，{$e->getMessage()}！");
                Db::name('StoreProfitUsed')->where(['trs_no' => $vo['trs_no']])->update(['pay_desc' => $e->getMessage()]);
            }
        }
    }

}