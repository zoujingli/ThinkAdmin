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
        if (empty($this->member['status'])) {
            $this->error('账户已被冻结，不能操作订单数据哦！');
        }
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
        $rules = $this->request->post('rule', '');
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
        $order['amount_total'] = $order['amount_goods'];
        try {
            // 订单数据写入
            $this->app->db->name('ShopOrder')->insert($order);
            $this->app->db->name('ShopOrderItem')->insertAll($items);
            // 同步商品库存及销量
            foreach ($codes as $code) GoodsService::instance()->syncStock($code);
            // 返回前端订单编号
            $this->success('订单创建成功，请补全收货地址后支付！', [
                'order_no' => $order['order_no'], 'reduct' => $order['amount_reduct'],
            ]);
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
            'order_no.require'   => '订单单号不能为空！',
            'address_id.require' => '收货地址不能为空！',
        ]);
        // 收货地址
        $map = ['mid' => $this->mid, 'id' => $data['address_id']];
        $address = $this->app->db->name('StoreMemberAddress')->where($map)->where(['deleted' => 0])->find();
        if (empty($address)) $this->error('会员收货地址异常！');
        // 订单检查
        $map = ['order_no' => $data['order_no'], 'mid' => $this->mid];
        $order = $this->app->db->name('ShopOrder')->where($map)->whereIn('status', [1, 2])->find();
        if (empty($order)) $this->error('订单状态异常，请重新下单！');
        $update = ['status' => 2];
        $update['truck_address_id'] = $data['address_id'];
        $update['truck_name'] = $address['name'];
        $update['truck_phone'] = $address['phone'];
        $update['truck_province'] = $address['province'];
        $update['truck_city'] = $address['city'];
        $update['truck_area'] = $address['area'];
        $update['truck_address'] = $address['address'];
        // 运费计算
        $result = TruckService::instance()->amount($address['province'], $order['express_rule_number'], $order['price_discount']);
        $update['price_express'] = $result['amount'];
        $update['price_total'] = $order['price_discount'] + $result['amount'];
        $update['express_rule_content'] = $result['content'];
        if ($this->app->db->name('ShopOrder')->where($map)->update($update) !== false) {
            $this->success('订单确认成功！', $this->_getPaymentParams($order['order_no'], $order['price_total'] - $order['price_reduction']));
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
            $params = $this->_getPaymentParams($order['order_no'], $order['amount_total'] - $order['amount_reduct']);
            $this->success('获取支付参数成功！', $params);
        } catch (HttpResponseException $exception) {
            throw  $exception;
        } catch (\Exception $exception) {
            $this->error("获取支付参数失败，{$exception->getMessage()}");
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
        $query = $this->_query('ShopOrder')->equal('status,order_no');
        $result = $query->where($map)->order('id desc')->page(true, false, false, 20);
        if (count($result['list']) > 0) {
            $codes = array_unique(array_column($result['list'], 'order_no'));
            $items = $this->app->db->name('ShopOrderItem')->whereIn('order_no', $codes)->select()->toArray();
            foreach ($result['list'] as &$vo) {
                [$vo['count'], $vo['items']] = [0, []];
                foreach ($items as $item) if ($vo['order_no'] === $item['order_no']) {
                    $vo['items'][] = $item;
                    $vo['count'] += $item['stock_sales'];
                }
            }
        }
        $this->success('获取订单数据成功！', $result);
    }

    /**
     * 订单取消
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function cancel()
    {
        $map = $this->_vali(['order_no.require' => '订单号不能为空！']);
        $order = $this->app->db->name('ShopOrder')->where(['mid' => $this->mid])->where($map)->find();
        if (empty($order)) $this->error('订单查询失败，请稍候再试！');
        if (in_array($order['status'], [1, 2])) {
            $result = $this->app->db->name('ShopOrder')->where($map)->update([
                'status'          => 0,
                'cancel_status'   => 1,
                'cancel_remark'   => '用户主动取消订单！',
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
        $where = $this->_vali(['mid' => $this->mid, 'order_no.require' => '订单号不能为空！']);
        $order = $this->app->db->name('ShopOrder')->where($where)->find();
        if (empty($order)) $this->error('订单查询失败，请稍候再试！');
        if (in_array($order['status'], [4])) {
            if ($this->app->db->name('ShopOrder')->where($where)->update(['status' => '5']) !== false) {
                // OrderService::instance()->syncConfrimOrderAmount($order['order_no']);
                $this->success('订单确认成功！');
            } else {
                $this->error('订单确认失败，请稍候再试！');
            }
        } else {
            $this->error('该订单状态不允许确认哦~');
        }
    }

    /**
     * 提交退换货订单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function createRefund()
    {
        $input = $this->_vali([
            'order_no.require'       => '订单单号不能为空！',
            'goodsinfo.require'      => '待处理商品不能为空！',
            'refund_content.require' => '提交申请退货描述！',
            'type.require'           => '操作类型不能为空！',
            'refund_images'          => input('refund_images', ''),
        ]);
        $input['goodsinfo'] = json_decode($input['goodsinfo'], true);
        if (!is_array($input['goodsinfo'])) $this->error('待处理的商品不能为空！');
        $map = [['order_no', '=', $input['order_no']], ['status', 'in', [3, 4, 5, 6]]];
        $order = $this->app->db->name('ShopOrder')->where(['pay_state' => 1])->where($map)->find();
        // $order = $this->app->db->name('ShopOrder')->where(['order_no' => $input['order_no']])->find();
        if (empty($order)) $this->error('订单状态不允许退换货！');
        try {
            if (OrderService::instance()->refund($input['order_no'], $input, $input['goodsinfo'])) {
                $this->success('提交退换货成功！');
            } else {
                $this->error("提交退换货失败！");
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->success("提交退换货失败，请稍候再试!");
        }
    }

    /**
     * 获取退换货申请列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function queryRefund()
    {
        $query = $this->_query('ShopOrderRefund')->in('refund_status#status,order_no')->equal('group_no,refund_no');
        $query->where(['mid' => $this->mid])->fieldRaw('group_no,sum(refund_number) refund_number,sum(refund_amount) refund_amount,refund_status,type');
        $result = $query->group('group_no')->page(true, false, false, 15);
        if (count($result['list']) > 0) {
            $unis = array_unique(array_column($result['list'], 'group_no'));
            $list = $this->app->db->name('ShopOrderRefund')->whereIn('group_no', $unis)->select()->toArray();
            foreach ($result['list'] as &$vo) {
                $vo['list'] = [];
                foreach ($list as $item) if ($item['group_no'] === $vo['group_no']) $vo['list'][] = $item;
            }
        }
        $this->success('获取退换货申请列表', $result);
    }

    /**
     * 获取可退货订单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getRefundOrder()
    {
        $map = $this->_vali(['order_no.require' => '订单编号不能为空！']);
        $order = $this->app->db->name('ShopOrder')->where(['mid' => $this->mid])->where($map)->find();
        if (empty($order)) $this->error('订单查询失败！');
        $order['list'] = $this->app->db->name('ShopOrderItem')->where($map)->select()->toArray();
        $rlist = $this->app->db->name('ShopOrderRefund')->where($map)->whereIn('refund_status', [1, 2, 3])->select()->toArray();
        if (count($order['list']) > 0) foreach ($order['list'] as &$vo) if (count($rlist) > 0) foreach ($rlist as $rule) {
            if ($vo['goods_id'] === $rule['goods_id'] && $vo['goods_spec'] === $rule['goods_spec']) {
                $vo['number_goods'] -= $rule['refund_number'];
            }
        }
        $this->success('获取订单成功', $order);
    }

    /**
     * 订单状态统计
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function total()
    {
        $query = $this->app->db->name('ShopOrder');
        $query->fieldRaw('mid,status,count(1) count')->where(['mid' => $this->mid]);
        $this->success('获取订单统计成功！', $query->group('status')->select()->toArray());
    }

}