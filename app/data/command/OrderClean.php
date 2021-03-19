<?php

namespace app\data\command;

use app\data\service\OrderService;
use think\admin\Command;
use think\admin\Exception;
use think\console\Input;
use think\console\Output;

/**
 * 商城订单自动清理
 * Class OrderClean
 * @package app\data\command
 */
class OrderClean extends Command
{
    protected function configure()
    {
        $this->setName('xdata:OrderClean');
        $this->setDescription('批量清理商城订单数据');
    }

    /**
     * 业务指令执行
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws Exception
     */
    protected function execute(Input $input, Output $output)
    {
        $this->_autoCancelOrder();
        $this->_autoRemoveOrder();
    }

    /**
     * 自动取消30分钟未支付的订单
     * @throws Exception
     */
    private function _autoCancelOrder()
    {
        try {
            $map = [];
            $map[] = ['status', '<', 3];
            $map[] = ['payment_status', '=', 0];
            $map[] = ['create_at', '<', date('Y-m-d H:i:s', strtotime('-30 minutes'))];
            [$total, $count] = [$this->app->db->name('ShopOrder')->where($map)->count(), 0];
            $this->app->db->name('ShopOrder')->where($map)->select()->map(function ($item) use ($total, &$count) {
                $this->queue->message($total, ++$count, "开始取消未支付的订单 {$item['order_no']}");
                $this->app->db->name('ShopOrder')->where(['order_no' => $item['order_no']])->update([
                    'status'          => 0,
                    'cancel_status'   => 1,
                    'cancel_datetime' => date('Y-m-d H:i:s'),
                    'cancel_remark'   => '30分钟未完成支付已自动取消',
                ]);
                OrderService::instance()->stock($item['order_no']);
                $this->queue->message($total, $count, "完成取消未支付的订单 {$item['order_no']}", 1);
            });
        } catch (\Exception $exception) {
            $this->queue->error($exception->getMessage());
        }
    }

    /**
     * 自动清理已经取消的订单
     * @throws Exception
     */
    private function _autoRemoveOrder()
    {
        try {
            $map = [];
            $map[] = ['status', '=', 0];
            $map[] = ['payment_status', '=', 0];
            $map[] = ['create_at', '<', date('Y-m-d H:i:s', strtotime('-3 days'))];
            [$total, $count] = [$this->app->db->name('ShopOrder')->where($map)->count(), 0];
            foreach ($this->app->db->name('ShopOrder')->where($map)->cursor() as $item) {
                $this->queue->message($total, ++$count, "开始清理已取消的订单 {$item['order_no']}");
                $this->app->db->name('ShopOrder')->where(['order_no' => $item['order_no']])->delete();
                $this->app->db->name('ShopOrderItem')->where(['order_no' => $item['order_no']])->delete();
                $this->queue->message($total, $count, "完成清理已取消的订单 {$item['order_no']}", 1);
            }
        } catch (\Exception $exception) {
            $this->queue->error($exception->getMessage());
        }
    }
}