<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\command;

use app\data\model\ShopOrder;
use app\data\model\ShopOrderItem;
use app\data\service\OrderService;
use think\admin\Command;
use think\admin\Exception;
use think\console\Input;
use think\console\Output;
use think\Model;

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
            $map = [['status', '<', 3], ['payment_status', '=', 0]];
            $map[] = ['create_at', '<', date('Y-m-d H:i:s', strtotime('-30 minutes'))];
            [$count, $total] = [0, ($result = ShopOrder::mk()->where($map)->select())->count()];
            $result->map(function (Model $item) use ($total, &$count) {
                $this->queue->message($total, ++$count, "开始取消未支付的订单 {$item['order_no']}");
                $item->save(['status' => 0, 'cancel_status' => 1, 'cancel_datetime' => date('Y-m-d H:i:s'), 'cancel_remark' => '自动取消30分钟未完成支付']);
                OrderService::stock($item['order_no']);
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
            $map = [['status', '=', 0], ['payment_status', '=', 0]];
            $map[] = ['create_at', '<', date('Y-m-d H:i:s', strtotime('-3 days'))];
            [$count, $total] = [0, ($result = ShopOrder::mk()->where($map)->select())->count()];
            $result->map(function (Model $item) use ($total, &$count) {
                $this->queue->message($total, ++$count, "开始清理已取消的订单 {$item['order_no']}");
                ShopOrder::mk()->where(['order_no' => $item['order_no']])->delete();
                ShopOrderItem::mk()->where(['order_no' => $item['order_no']])->delete();
                $this->queue->message($total, $count, "完成清理已取消的订单 {$item['order_no']}", 1);
            });
        } catch (\Exception $exception) {
            $this->queue->error($exception->getMessage());
        }
    }
}