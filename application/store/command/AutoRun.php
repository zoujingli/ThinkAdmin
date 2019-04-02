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
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\store\command;

use think\console\Command;
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
     * 执行指令
     * @param \think\console\Input $input
     * @param \think\console\Output $output
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function execute(\think\console\Input $input, \think\console\Output $output)
    {
        # 自动取消30分钟未支付的订单
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
        # 清理一天前未支付的订单
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

}