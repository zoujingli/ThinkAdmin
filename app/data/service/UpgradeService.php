<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 用户等级升级服务
 * Class UpgradeService
 * @package app\data\service
 */
class UpgradeService extends Service
{
    /**
     * 同步计算用户级别
     * @param integer $uid 指定用户UID
     * @param boolean $parent 同步计算上级
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function syncLevel(int $uid, bool $parent = true): bool
    {
        $user = $this->app->db->name('DataUser')->where(['id' => $uid])->find();
        if (empty($user)) return true;
        [$vipName, $vipNumber] = ['普通用户', 0];
        // 统计历史数据
        $teamsDirect = $this->app->db->name('DataUser')->where(['pid1' => $uid])->count();
        $teamsIndirect = $this->app->db->name('DataUser')->where(['pid2' => $uid])->count();
        $teamsUsers = $this->app->db->name('DataUser')->where(['pid1|pid2' => $uid])->count();
        $orderAmount = $this->app->db->name('ShopOrder')->where("uid={$uid} and status>=4")->sum('amount_total');
        // 计算用户级别
        foreach ($this->app->db->name('DataUserUpgrade')->where(['status' => 1])->order('number desc')->cursor() as $item) {
            $l1 = empty($item['goods_vip_status']) || $user['buy_vip_entry'] > 0;
            $l2 = empty($item['teams_users_status']) || $item['teams_users_number'] <= $teamsUsers;
            $l3 = empty($item['order_amount_status']) || $item['order_amount_number'] <= $orderAmount;
            $l4 = empty($item['teams_direct_status']) || $item['teams_direct_number'] <= $teamsDirect;
            $l5 = empty($item['teams_indirect_status']) || $item['teams_indirect_number'] <= $teamsIndirect;
            if (
                ($item['upgrade_type'] == 0 && ($l1 || $l2 || $l3 || $l4 || $l5)) /* 满足任何条件可以等级 */
                ||
                ($item['upgrade_type'] == 1 && ($l1 && $l2 && $l3 && $l4 && $l5)) /* 满足所有条件可以等级 */
            ) {
                [$vipName, $vipNumber] = [$item['name'], $item['number']];
                break;
            }
        }
        // 购买商品升级
        $query = $this->app->db->name('ShopOrderItem')->alias('b')->join('shop_order a', 'b.order_no=a.order_no');
        $tmpNumber = $query->whereRaw("a.uid={$uid} and a.payment_status=1 and a.status>=4 and b.vip_entry=1")->max('b.vip_number');
        if ($tmpNumber > $vipNumber) {
            $map = ['status' => 1, 'number' => $tmpNumber];
            $upgrade = $this->app->db->name('DataUserUpgrade')->where($map)->find();
            if (!empty($upgrade)) [$vipName, $vipNumber] = [$upgrade['name'], $upgrade['number']];
        }
        // 统计订单金额
        $orderAmountTotal = $this->app->db->name('ShopOrder')->whereRaw("uid={$uid} and status>=4")->sum('amount_goods');
        $teamsAmountDirect = $this->app->db->name('ShopOrder')->whereRaw("puid1={$uid} and status>=4")->sum('amount_goods');
        $teamsAmountIndirect = $this->app->db->name('ShopOrder')->whereRaw("puid2={$uid} and status>=4")->sum('amount_goods');
        // 更新用户数据
        $data = [
            'vip_name'              => $vipName,
            'vip_number'            => $vipNumber,
            'teams_users_total'     => $teamsUsers,
            'teams_users_direct'    => $teamsDirect,
            'teams_users_indirect'  => $teamsIndirect,
            'teams_amount_total'    => $teamsAmountDirect + $teamsAmountIndirect,
            'teams_amount_direct'   => $teamsAmountDirect,
            'teams_amount_indirect' => $teamsAmountIndirect,
            'order_amount_total'    => $orderAmountTotal,
        ];
        if ($data['vip_number'] !== $user['vip_number']) {
            $data['vip_datetime'] = date('Y-m-d H:i:s');
        }
        $this->app->db->name('DataUser')->where(['id' => $uid])->update($data);
        return ($parent && $user['pid2'] > 0) ? $this->syncLevel($user['pid2'], false) : true;
    }
}