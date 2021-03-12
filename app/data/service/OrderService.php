<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 订单数据服务
 * Class OrderService
 * @package app\data\service
 */
class OrderService extends Service
{
    /**
     * 获取随机减免金额
     * @return float
     */
    public function getReduct(): float
    {
        return rand(1, 100) / 100;
    }

    /**
     * 同步订单关联商品的库存
     * @param string $order_no 订单编号
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function syncStock(string $order_no): bool
    {
        $map = ['order_no' => $order_no];
        $codes = $this->app->db->name('ShopOrderItem')->where($map)->column('goods_code');
        foreach (array_unique($codes) as $code) GoodsService::instance()->syncStock($code);
        return true;
    }

    /**
     * 刷新用户入会礼包
     * @param integer $uid
     * @return integer
     * @throws \think\db\exception\DbException
     */
    private function syncUserEntry(int $uid): int
    {
        // 检查是否购买入会礼包
        $query = $this->app->db->table('shop_order a')->join('shop_order_item b', 'a.order_no=b.order_no');
        $count = $query->where("a.uid={$uid} and a.status>=4 and a.payment_status=1 and b.vip_entry>0")->count();
        $buyVipEntry = $count > 0 ? 1 : 0;
        // 查询用户最后支付时间
        $buyLastMap = [['uid', '=', $uid], ['status', '>=', 4], ['payment_status', '=', 1]];
        $buyLastDate = $this->app->db->name('ShopOrder')->where($buyLastMap)->max('payment_datetime');
        // 更新用户支付信息
        $this->app->db->name('DataUser')->where(['id' => $uid])->update([
            'buy_vip_entry' => $buyVipEntry, 'buy_last_date' => $buyLastDate,
        ]);
        return $buyVipEntry;
    }

    /**
     * 根据订单更新用户等级
     * @param string $order_no
     * @return array|null [USER, ORDER, ENTRY]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function syncUserLevel(string $order_no): ?array
    {
        // 目标订单数据
        $map = [['order_no', '=', $order_no], ['status', '>=', 4]];
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) return null;
        // 订单用户数据
        $user = $this->app->db->name('DataUser')->where(['id' => $order['uid']])->find();
        if (empty($user)) return null;
        // 更新用户购买资格
        $entry = $this->syncUserEntry($order['uid']);
        // 尝试绑定代理用户
        if (empty($user['pid1']) && ($order['puid1'] > 0 || $user['pid1'] > 0)) {
            $puid1 = $order['puid1'] > 0 ? $order['puid1'] : $user['bid'];
            UpgradeService::instance()->bindAgent($user['id'], $puid1);
        }
        // 重置用户信息并绑定订单
        $user = $this->app->db->name('DataUser')->where(['id' => $order['uid']])->find();
        if ($user['pid1'] > 0) {
            $this->app->db->name('ShopOrder')->where(['order_no' => $order_no])->update([
                'puid1' => $user['pid1'], 'puid2' => $user['pid2'],
            ]);
        }
        // 重新计算用户等级
        UpgradeService::instance()->syncLevel($user['id']);
        return [$user, $order, $entry];
    }

    /**
     * 绑定订单详情数据
     * @param array $data
     * @param boolean $fromer
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function buildData(array &$data = [], $fromer = true): array
    {
        // 关联发货信息
        $nobs = array_unique(array_column($data, 'order_no'));
        $trucks = $this->app->db->name('ShopOrderSend')->whereIn('order_no', $nobs)->column('*', 'order_no');
        foreach ($trucks as &$item) unset($item['id'], $item['uid'], $item['status'], $item['deleted'], $item['create_at']);
        // 关联订单商品
        $query = $this->app->db->name('ShopOrderItem')->where(['status' => 1, 'deleted' => 0]);
        $items = $query->withoutField('id,uid,status,deleted,create_at')->whereIn('order_no', $nobs)->select()->toArray();
        // 关联用户数据
        $fields = 'phone,username,nickname,headimg,status';
        UserService::instance()->buildByUid($data, 'uid', 'user', $fields);
        if ($fromer) UserService::instance()->buildByUid($data, 'puid1', 'fromer', $fields);
        foreach ($data as &$vo) {
            [$vo['sales'], $vo['truck'], $vo['items']] = [0, $trucks[$vo['order_no']] ?? [], []];
            foreach ($items as $item) if ($vo['order_no'] === $item['order_no']) {
                $vo['sales'] += $item['stock_sales'];
                $vo['items'][] = $item;
            }
        }
        return $data;
    }

}