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

namespace app\data\service;

use app\data\model\BaseUserDiscount;
use app\data\model\DataUser;
use app\data\model\ShopOrder;
use app\data\model\ShopOrderItem;
use app\data\model\ShopOrderSend;
use think\admin\Service;

/**
 * 商城订单数据服务
 * Class OrderService
 * @package app\data\service
 */
class OrderService extends Service
{
    /**
     * 获取随机减免金额
     * @return float
     */
    public static function getReduct(): float
    {
        return rand(1, 100) / 100;
    }

    /**
     * 同步订单关联商品的库存
     * @param string $orderNo 订单编号
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function stock(string $orderNo): bool
    {
        $map = ['order_no' => $orderNo];
        $codes = ShopOrderItem::mk()->where($map)->column('goods_code');
        foreach (array_unique($codes) as $code) GoodsService::stock($code);
        return true;
    }

    /**
     * 根据订单更新用户等级
     * @param string $orderNo
     * @return array|null [USER, ORDER, ENTRY]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function upgrade(string $orderNo): ?array
    {
        // 目标订单数据
        $map = [['order_no', '=', $orderNo], ['status', '>=', 4]];
        $order = ShopOrder::mk()->where($map)->find();
        if (empty($order)) return null;
        // 订单用户数据
        $user = DataUser::mk()->where(['id' => $order['uuid']])->find();
        if (empty($user)) return null;
        // 更新用户购买资格
        $entry = static::vipEntry($order['uuid']);
        // 尝试绑定代理用户
        if (empty($user['pids']) && ($order['puid1'] > 0 || $user['pid1'] > 0)) {
            $puid1 = $order['puid1'] > 0 ? $order['puid1'] : $user['pid0'];
            UserUpgradeService::bindAgent($user['id'], $puid1);
        }
        // 重置用户信息并绑定订单
        $user = DataUser::mk()->where(['id' => $order['uuid']])->find();
        if ($user['pid1'] > 0) {
            ShopOrder::mk()->where(['order_no' => $orderNo])->update([
                'puid1' => $user['pid1'], 'puid2' => $user['pid2'],
            ]);
        }
        // 重新计算用户等级
        UserUpgradeService::upgrade($user['id'], true, $orderNo);
        return [$user, $order, $entry];
    }

    /**
     * 刷新用户入会礼包
     * @param integer $uuid 用户UID
     * @return integer
     */
    private static function vipEntry(int $uuid): int
    {
        // 检查是否购买入会礼包
        $query = ShopOrder::mk()->alias('a')->join('shop_order_item b', 'a.order_no=b.order_no');
        $entry = $query->where("a.uuid={$uuid} and a.status>=4 and a.payment_status=1 and b.vip_entry>0")->count() ? 1 : 0;
        // 用户最后支付时间
        $lastMap = [['uuid', '=', $uuid], ['status', '>=', 4], ['payment_status', '=', 1]];
        $lastDate = ShopOrder::mk()->where($lastMap)->order('payment_datetime desc')->value('payment_datetime');
        // 更新用户支付信息
        DataUser::mk()->where(['id' => $uuid])->update(['buy_vip_entry' => $entry, 'buy_last_date' => $lastDate]);
        return $entry;
    }

    /**
     * 获取等级折扣比例
     * @param int $disId 折扣方案ID
     * @param int $vipCode 等级序号
     * @param float $disRate 默认比例
     * @return array [方案编号, 折扣比例]
     */
    public static function discount(int $disId, int $vipCode, float $disRate = 100.00): array
    {
        if ($disId > 0) {
            $map = ['id' => $disId, 'status' => 1, 'deleted' => 0];
            $discount = BaseUserDiscount::mk()->where($map)->value('items');
            $disitems = json_decode($discount ?: '[]', true) ?: [];
            if (is_array($disitems) && count($disitems) > 0) foreach ($disitems as $vo) {
                if ($vo['level'] == $vipCode) $disRate = floatval($vo['discount']);
            }
        }
        return [$disId, $disRate];
    }

    /**
     * 绑定订单详情数据
     * @param array $data
     * @param boolean $from
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function buildData(array &$data = [], bool $from = true): array
    {
        if (empty($data)) return $data;
        // 关联发货信息
        $nobs = array_unique(array_column($data, 'order_no'));
        $trucks = ShopOrderSend::mk()->whereIn('order_no', $nobs)->column('*', 'order_no');
        foreach ($trucks as &$item) unset($item['id'], $item['uuid'], $item['status'], $item['deleted'], $item['create_at']);
        // 关联订单商品
        $query = ShopOrderItem::mk()->where(['status' => 1, 'deleted' => 0]);
        $items = $query->withoutField('id,uuid,status,deleted,create_at')->whereIn('order_no', $nobs)->select()->toArray();
        // 关联用户数据
        $fields = 'phone,username,nickname,headimg,status,vip_code,vip_name';
        UserAdminService::buildByUid($data, 'uuid', 'user', $fields);
        if ($from) UserAdminService::buildByUid($data, 'puid1', 'from', $fields);
        foreach ($data as &$vo) {
            [$vo['sales'], $vo['truck'], $vo['items']] = [0, $trucks[$vo['order_no']] ?? [], []];
            foreach ($items as $it) if ($vo['order_no'] === $it['order_no']) {
                $vo['sales'] += $it['stock_sales'];
                $vo['items'][] = $it;
            }
        }
        return $data;
    }
}