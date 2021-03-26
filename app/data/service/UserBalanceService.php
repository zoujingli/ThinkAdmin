<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 用户余额数据服务
 * Class UserBalanceService
 * @package app\data\service
 */
class UserBalanceService extends Service
{

    /**
     * 验证订单发放余额
     * @param string $orderNo
     * @return array [total, count]
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function confirm(string $orderNo): array
    {
        $map = [['status', '>=', 4], ['order_no', '=', $orderNo]];
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) throw new \think\admin\Exception('需处理的订单状态异常');

        if ($order['reward_balance'] > 0) data_save('DataUserBalance', [
            'uid'    => $order['uid'],
            'code'   => "CZ{$order['order_no']}",
            'name'   => "订单余额充值",
            'remark' => "来自订单 {$order['order_no']} 的余额充值 {$order['reward_balance']} 元",
            'amount' => $order['reward_balance'],
        ], 'code');

        return $this->amount($order['uid']);
    }

    /**
     * 同步刷新用户余额
     * @param int $uuid 用户UID
     * @param array $nots 排除的订单
     * @return array [total, count]
     * @throws \think\db\exception\DbException
     */
    public function amount(int $uuid, array $nots = []): array
    {
        if ($uuid > 0) {
            $total = abs($this->app->db->name('DataUserBalance')->whereRaw("uid='{$uuid}' and amount>0 and deleted=0")->sum('amount'));
            $count = abs($this->app->db->name('DataUserBalance')->whereRaw("uid='{$uuid}' and amount<0 and deleted=0")->sum('amount'));
            if (empty($nots)) {
                $this->app->db->name('DataUser')->where(['id' => $uuid])->update(['balance_total' => $total, 'balance_used' => $count]);
            } else {
                $count -= $this->app->db->name('DataUserBalance')->whereRaw("uid={$uuid}")->whereIn('code', $nots)->sum('amount');
            }
        } else {
            $total = abs($this->app->db->name('DataUserBalance')->whereRaw("amount>0 and deleted=0")->sum('amount'));
            $count = abs($this->app->db->name('DataUserBalance')->whereRaw("amount<0 and deleted=0")->sum('amount'));
        }
        return [$total, $count];
    }

}