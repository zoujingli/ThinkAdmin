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
     * 同步订单支付状态
     * @param string $orderno
     * @return bool
     */
    public function syncAmount(string $orderno): bool
    {
        return true;
    }

    /**
     * 获取随机减免金额
     * @return float
     */
    public function getReduct()
    {
        return rand(1, 100) / 100;
    }

    /**
     * 同步订单关联商品的库存
     * @param string $order_no 订单编号
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function syncStock(string $order_no)
    {
        $map = ['order_no' => $order_no];
        $codes = $this->app->db->name('ShopOrderItem')->where($map)->column('goods_code');
        foreach (array_unique($codes) as $code) GoodsService::instance()->syncStock($code);
        return true;
    }

    /**
     * 创建申请售后单
     * @param string $orderNo
     * @param array $data [type,refund_content,refund_images]
     * @param array $rules [[goods_id,goods_spec,refund_number]]
     * @return boolean
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function refund(string $orderNo, array $data, array $rules = [])
    {
        [$all, $map] = [[], ['order_no' => $orderNo]];
        $order = $this->app->db->name('StoreOrder')->where($map)->find();
        $olist = $this->app->db->name('StoreOrderList')->where($map)->select()->toArray();
        $rlist = $this->app->db->name('StoreOrderRefund')->where($map)->whereIn('refund_status', [1, 2, 3])->select()->toArray();
        $discountRate = $order['pay_price'] / $order['price_discount'];
        if (count($olist) > 0) foreach ($olist as &$vo) {
            $vo['discount_unit_amount'] = $vo['discount_amount'] / $vo['number_goods'] * $discountRate;
            if (count($rlist) > 0) foreach ($rlist as $rule) {
                if ($vo['goods_id'] === $rule['goods_id'] && $vo['goods_spec'] === $rule['goods_spec']) {
                    $vo['number_goods'] -= $rule['refund_number'];
                }
            }
        }
        // dump($olist);
        $data['group_no'] = CodeExtend::uniqidDate(18, "G");
        if (count($olist) > 0 && count($rules) > 0) foreach ($olist as &$vo) {
            foreach ($rules as $rule) if ($vo['goods_id'] === $rule['goods_id'] && $vo['goods_spec'] === $rule['goods_spec']) {
                if ($vo['number_goods'] - $rule['refund_number'] < 0) {
                    throw new \think\Exception("订单商品数量异常！");
                }
                $data['mid'] = $vo['mid'];
                $data['order_no'] = $orderNo;
                $data['goods_id'] = $vo['goods_id'];
                $data['goods_sku'] = $vo['goods_sku'];
                $data['goods_title'] = $vo['goods_title'];
                $data['goods_logo'] = $vo['goods_logo'];
                $data['goods_spec'] = $vo['goods_spec'];
                $data['number_goods'] = $vo['number_goods'];
                $data['goods_price_total'] = $vo['goods_price_total'];
                $data['goods_price_market'] = $vo['goods_price_market'];
                $data['refund_no'] = CodeExtend::uniqidDate(18, 'R');
                $data['refund_rate'] = $discountRate;
                $data['refund_number'] = $rule['refund_number'];
                $data['refund_amount'] = $rule['refund_number'] * $vo['discount_unit_amount'];
                $data['refund_status'] = 1;
                $data['discount_amount'] = $vo['discount_amount'];
                // 支付金额处理
                if ($order['pay_price'] < $data['refund_amount']) {
                    $data['refund_amount'] = $order['pay_price'];
                }
                $all[] = $data;
            }
        }
        if (empty($all)) throw new \think\Exception("没有需要处理的商品！");
        return $this->app->db->name('StoreOrderRefund')->strict(false)->insertAll($all) !== false;
    }
}