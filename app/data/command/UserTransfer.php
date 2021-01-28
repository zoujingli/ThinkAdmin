<?php

namespace app\data\command;

use app\data\service\DataService;
use think\admin\Command;
use think\console\Input;
use think\console\Output;
use WePay\Transfers;

/**
 * 用户提现处理
 * Class UserTransfer
 * @package app\data\command
 */
class UserTransfer extends Command
{
    protected function configure()
    {
        $this->setName('xdata:UserTransfer');
        $this->setDescription('批量执行线上打款操作');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws \think\db\exception\DbException
     */
    protected function execute(Input $input, Output $output)
    {
        $map = ['type' => 1, 'status' => 3];
        foreach ($this->app->db->name('DataUserTransfer')->where($map)->cursor() as $vo) try {
            $wechat = Transfers::instance(DataService::instance()->payment());
            $result = $wechat->create([
                'openid'           => $vo['openid'],
                'amount'           => $vo['amount'] * 100,
                'partner_trade_no' => $vo['code'],
                'spbill_create_ip' => '127.0.0.1',
                'check_name'       => 'NO_CHECK',
                'desc'             => '微信余额提现',
            ]);
            if ($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS') {
                $this->app->db->name('DataUserTransfer')->where(['code' => $vo['code']])->update([
                    'status'      => 4,
                    'trade_no'    => $result['partner_trade_no'],
                    'trade_time'  => $result['payment_time'],
                    'change_time' => date('Y-m-d H:i:s'),
                    'change_desc' => '线上提现成功',
                ]);
            } else {
                $this->app->db->name('DataUserTransfer')->where(['code' => $vo['code']])->update([
                    'change_time' => date('Y-m-d H:i:s'),
                    'change_desc' => $result['err_code_des'] ?? '线上提现失败',
                ]);
            }
        } catch (\Exception $exception) {
            $this->output->writeln("订单 {$vo['code']} 提现失败，{$exception->getMessage()}");
            $this->app->db->name('DataUserTransfer')->where(['code' => $vo['code']])->update([
                'change_time' => date('Y-m-d H:i:s'),
                'change_desc' => $exception->getMessage(),
            ]);
        }
    }

}