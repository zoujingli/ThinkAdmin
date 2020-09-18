<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\GoodsService;
use app\data\service\OrderService;
use app\data\service\TruckService;
use app\wechat\service\WechatService;
use think\admin\extend\CodeExtend;
use think\exception\HttpResponseException;

/**
 * 会员订单数据接口
 * Class Order
 * @package app\data\controller\api\auth
 */
class Order extends Auth
{
    /**
     * 控制器初始化
     */
    protected function initialize()
    {
        parent::initialize();
        if (empty($this->member['status'])) {
            $this->error('账户已被冻结，不能操作订单数据哦！');
        }
    }

    /**
     * 获取订单列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get()
    {
        $map = [['mid', '=', $this->mid]];
        if (!$this->request->has('order_no', 'param', true)) {
            $map[] = ['status', 'in', [0, 2, 3, 4, 5]];
        }
        $query = $this->_query('ShopOrder')->in('status')->equal('order_no');
        $result = $query->where($map)->order('id desc')->page(true, false, false, 20);
        if (count($result['list']) > 0) OrderService::instance()->buildItemData($result['list']);
        $this->success('获取订单数据成功！', $result);
    }

    /**
     * 会员创建订单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        // 商品规则
        $rules = $this->request->post('items', '');
        if (empty($rules)) $this->error('商品规则不能为空！');
        // 订单数据
        [$codes, $items] = [[], []];
        $order = ['mid' => $this->mid, 'from' => input('from_mid', '0'), 'status' => 1];
        $order['order_no'] = CodeExtend::uniqidDate(18, 'N');
        // 推荐人处理
        if ($order['from'] == $this->mid) {
            $order['from'] = 0;
        }
        if ($order['from'] > 0) {
            $map = ['id' => $order['from'], 'status' => 1];
            $from = $this->app->db->name('ShopMember')->where($map)->find();
            if (empty($from)) $this->error('推荐人信息异常！');
        }
        foreach (explode('||', $rules) as $rule) {
            [$code, $spec, $count] = explode('@', $rule);
            // 商品信息检查
            $map = ['code' => $code, 'status' => 1, 'deleted' => 0];
            $goodsInfo = $this->app->db->name('ShopGoods')->where($map)->find();
            if (empty($goodsInfo)) $this->error('商品主体异常，请稍候再试！');
            $map = ['goods_code' => $code, 'goods_spec' => $spec, 'status' => 1];
            $goodsItem = $this->app->db->name('ShopGoodsItem')->where($map)->find();
            if (empty($goodsItem)) $this->error('商品规格异常，请稍候再试！');
            // 商品库存检查
            if ($goodsItem['stock_sales'] + $count > $goodsItem['stock_total']) {
                $this->error('商品库存不足，请购买其它商品！');
            }
            // 订单详情处理
            $items[] = [
                'mid'           => $order['mid'],
                'order_no'      => $order['order_no'],
                // 商品字段
                'goods_name'    => $goodsInfo['name'],
                'goods_cover'   => $goodsInfo['cover'],
                'goods_sku'     => $goodsItem['goods_sku'],
                'goods_code'    => $goodsItem['goods_code'],
                'goods_spec'    => $goodsItem['goods_spec'],
                // 数量处理
                'stock_sales'   => $count,
                'truck_tcode'   => $goodsInfo['truck_tcode'],
                'truck_count'   => $goodsItem['number_express'] * $count,
                // 费用字段
                'price_market'  => $goodsItem['price_market'],
                'price_selling' => $goodsItem['price_selling'],
                'total_market'  => $goodsItem['price_market'] * $count,
                'total_selling' => $goodsItem['price_selling'] * $count,
            ];
        }
        // 统计订单金额
        $order['amount_reduct'] = OrderService::instance()->getReduct();
        $order['amount_goods'] = array_sum(array_column($items, 'total_selling'));
        $order['amount_total'] = $order['amount_goods'] - $order['amount_reduct'];
        try {
            // 订单数据写入
            $this->app->db->name('ShopOrder')->insert($order);
            $this->app->db->name('ShopOrderItem')->insertAll($items);
            // 同步商品库存及销量
            foreach ($codes as $code) GoodsService::instance()->syncStock($code);
            // 返回订单数据给接口
            $order['items'] = $items;
            $this->success('预购订单创建成功，请补全收货地址', $order);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error("创建订单失败，{$exception->getMessage()}");
        }
    }

    /**
     * 订单信息完成
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function perfect()
    {
        $data = $this->_vali([
            'code.require'     => '地址编号不能为空！',
            'order_no.require' => '订单单号不能为空！',
        ]);
        // 会员收货地址
        $map = ['mid' => $this->mid, 'code' => $data['code'], 'deleted' => 0];
        $addr = $this->app->db->name('DataMemberAddress')->where($map)->find();
        if (empty($addr)) $this->error('会员收货地址异常！');
        // 订单状态检查
        $map = ['mid' => $this->mid, 'order_no' => $data['order_no']];
        $order = $this->app->db->name('ShopOrder')->where($map)->whereIn('status', [1, 2])->find();
        $tCount = $this->app->db->name('ShopOrderItem')->where($map)->sum('truck_count');
        if (empty($order)) $this->error('不能修改收货地址哦！');
        // 根据地址计算运费
        $map = ['status' => 1, 'deleted' => 0, 'order_no' => $data['order_no']];
        $tCode = $this->app->db->name('ShopOrderItem')->where($map)->column('truck_tcode');
        [$amount, $tCount, $tCode, $remark] = TruckService::instance()->amount($tCode, $addr['province'], $addr['city'], $tCount);
        // 创建订单发货信息
        $express = [
            'mid'             => $this->mid, 'status' => 1,
            'template_code'   => $tCode, 'template_count' => $tCount,
            'template_remark' => $remark, 'template_amount' => $amount,
        ];
        $express['order_no'] = $data['order_no'];
        $express['address_code'] = $data['code'];
        $express['address_name'] = $addr['name'];
        $express['address_phone'] = $addr['phone'];
        $express['address_province'] = $addr['province'];
        $express['address_city'] = $addr['city'];
        $express['address_area'] = $addr['area'];
        $express['address_content'] = $addr['address'];
        $express['address_datetime'] = date('Y-m-d H:i:s');
        data_save('ShopOrderSend', $express, 'order_no');
        // 更新订单状态，刷新订单金额
        $map = ['mid' => $this->mid, 'order_no' => $data['order_no']];
        $update = ['status' => 2, 'amount_express' => $express['template_amount']];
        $update['amount_total'] = $order['amount_goods'] + $amount - $order['amount_reduct'] - $order['amount_discount'];
        if ($this->app->db->name('ShopOrder')->where($map)->update($update) !== false) {
            $this->success('订单确认成功！', $this->_getPaymentParams($order['order_no'], $order['amount_total']));
        } else {
            $this->error('订单确认失败，请稍候再试！');
        }
    }

    /**
     * 获取订单支付状态
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function payment()
    {
        $map = $this->_vali(['order_no.require' => '订单单号不能为空！']);
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) $this->error('获取订单数据失败，请稍候再试！');
        if ($order['status'] != 2) $this->error('该订单不能发起支付哦！');
        if ($order['payment_status']) $this->error('订单已经支付，不需要再次支付哦！');
        try {
            $params = $this->_getPaymentParams($order['order_no'], $order['amount_total']);
            $this->success('获取支付参数成功！', $params);
        } catch (HttpResponseException $exception) {
            throw  $exception;
        } catch (\Exception $exception) {
            $this->error("创建支付参数失败，{$exception->getMessage()}");
        }
    }

    /**
     * 获取订单支付参数
     * @param string $code 订单单号
     * @param string $amount 支付金额
     * @return array
     */
    private function _getPaymentParams(string $code, string $amount): array
    {
        try {
            return WechatService::WePayOrder()->create([
                'body'             => '商城订单支付',
                'openid'           => $this->member['openid'],
                'out_trade_no'     => $code,
                'total_fee'        => $amount * 100,
                'trade_type'       => 'JSAPI',
                'notify_url'       => sysuri('@data/api.notify/wxpay/type/order', [], false, true),
                'spbill_create_ip' => $this->app->request->ip(),
            ]);
        } catch (\Exception $exception) {
            $this->error("创建支付参数失败，{$exception->getMessage()}");
        }
    }


    /**
     * 主动取消未支付的订单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function cancel()
    {
        $map = $this->_vali([
            'mid.value'        => $this->mid,
            'order_no.require' => '订单号不能为空！',
        ]);
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) $this->error('订单查询失败，请稍候再试！');
        if (in_array($order['status'], [1, 2])) {
            $result = $this->app->db->name('ShopOrder')->where($map)->update([
                'status'          => 0,
                'cancel_status'   => 1,
                'cancel_remark'   => '会员主动取消订单！',
                'cancel_datetime' => date('Y-m-d H:i:s'),
            ]);
            if ($result !== false && OrderService::instance()->syncStock($order['order_no'])) {
                $this->success('订单取消成功！');
            } else {
                $this->error('订单取消失败，请稍候再试！');
            }
        } else {
            $this->error('该订单状态不能取消哦~');
        }
    }

    /**
     * 订单确认收货
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function confirm()
    {
        $map = $this->_vali([
            'mid.value'        => $this->mid,
            'order_no.require' => '订单号不能为空！',
        ]);
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) $this->error('订单查询失败，请稍候再试！');
        if (in_array($order['status'], [4])) {
            if ($this->app->db->name('ShopOrder')->where($map)->update(['status' => 5]) !== false) {
                // OrderService::instance()->syncConfrimOrderAmount($order['order_no']);
                $this->success('订单确认成功！');
            } else {
                $this->error('订单确认失败，请稍候再试！');
            }
        } else {
            $this->error('订单不能确认收货哦~');
        }
    }

    /**
     * 订单状态统计
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function total()
    {
        $map = ['mid' => $this->mid, 'deleted' => 0];
        $data = ['t0' => 0, 't1' => 0, 't2' => 0, 't3' => 0, 't4' => 0, 't5' => 0];
        $query = $this->app->db->name('ShopOrder')->fieldRaw('status,count(1) count');
        $query->where($map)->group('status')->select()->each(function ($item) use (&$data) {
            $data["t{$item['status']}"] = $item['count'];
        });
        $this->success('获取状态统计成功！', $data);
    }

    /**
     * 物流追踪查询
     */
    public function track()
    {
        try {
            $data = $this->_vali([
                'code.require' => '快递编号不能为空！', 'number.require' => '配送单号不能为空！',
            ]);
            $result = TruckService::instance()->query($data['code'], $data['number']);
            empty($result['code']) ? $this->error($result['info']) : $this->success('快递追踪信息', $result);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}