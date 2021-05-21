<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 用户返利数据服务
 * Class UserRebateService
 * @package app\data\service
 */
class UserRebateService extends Service
{
    /**
     * 同步刷新用户返利
     * @param integer $uuid
     * @return array [total, count, lock]
     * @throws \think\db\exception\DbException
     */
    public function amount(int $uuid): array
    {
        if ($uuid > 0) {
            $count = $this->app->db->name('DataUserTransfer')->whereRaw("uid='{$uuid}' and status>0")->sum('amount');
            $total = $this->app->db->name('DataUserRebate')->whereRaw("uid='{$uuid}' and status=1 and deleted=0")->sum('amount');
            $locks = $this->app->db->name('DataUserRebate')->whereRaw("uid='{$uuid}' and status=0 and deleted=0")->sum('amount');
            $this->app->db->name('DataUser')->where(['id' => $uuid])->update(['rebate_total' => $total, 'rebate_used' => $count, 'rebate_lock' => $locks]);
        } else {
            $count = $this->app->db->name('DataUserTransfer')->whereRaw("status>0")->sum('amount');
            $total = $this->app->db->name('DataUserRebate')->whereRaw("status=1 and deleted=0")->sum('amount');
            $locks = $this->app->db->name('DataUserRebate')->whereRaw("status=0 and deleted=0")->sum('amount');
        }
        return [$total, $count, $locks];
    }

    /**
     * 确认收货订单处理
     * @param string $orderNo
     * @return array [status, message]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function confirm(string $orderNo): array
    {
        $map = [['status', '>=', 4], ['order_no', '=', $orderNo]];
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) return [0, '需处理的订单状态异常！'];

        $map = [['status', '=', 0], ['order_no', 'like', "{$orderNo}%"]];
        $this->app->db->name('DataUserRebate')->where($map)->update(['status' => 1]);
        if (UserUpgradeService::instance()->upgrade($order['uid'])) {
            return [1, '重新计算用户金额成功！'];
        } else {
            return [0, '重新计算用户金额失败！'];
        }
    }
}