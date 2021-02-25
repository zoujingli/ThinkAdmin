<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\GoodsService;
use app\data\service\OrderService;
use app\data\service\PaymentService;
use app\data\service\TruckService;
use app\data\service\UserService;
use think\admin\extend\CodeExtend;
use think\exception\HttpResponseException;

/**
 * 用户订单数据接口
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
        if (empty($this->user['status'])) {
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
        $map = ['uid' => $this->uuid, 'deleted' => 0];
        $query = $this->_query('ShopOrder')->in('status')->equal('order_no');
        $result = $query->where($map)->order('id desc')->page(true, false, false, 20);
        if (count($result['list']) > 0) OrderService::instance()->buildItemData($result['list']);
        $this->success('获取订单数据成功！', $result);
    }

    /**
     * 用户创建订单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        // 商品规则
        $rules = $this->request->post('items', '');
        if (empty($rules)) $this->error('商品不能为空');
        // 订单数据
        [$codes, $items, $truckType] = [[], [], -1];
        $order = ['uid' => $this->uuid];
        $order['order_no'] = CodeExtend::uniqidDate(18, 'N');
        // 推荐人处理
        $order['from'] = input('from_uid', $this->user['pid1']);
        if ($order['from'] == $this->uuid) $order['from'] = 0;
        if ($order['from'] > 0) {
            $map = ['id' => $order['from'], 'status' => 1];
            $fromer = $this->app->db->name('DataUser')->where($map)->find();
            if (empty($fromer)) $this->error('未找到推荐人');
        }
        foreach (explode('||', $rules) as $rule) {
            [$code, $spec, $count] = explode('@', $rule);
            // 商品信息检查
            $goodsInfo = $this->app->db->name('ShopGoods')->where(['code' => $code, 'status' => 1, 'deleted' => 0])->find();
            $goodsItem = $this->app->db->name('ShopGoodsItem')->where(['goods_code' => $code, 'goods_spec' => $spec, 'status' => 1])->find();
            if (empty($goodsInfo)) $this->error('商品数据查询异常');
            if (empty($goodsItem)) $this->error('商品规格查询异常');
            // 商品类型检查
            if ($truckType < 0) $truckType = $goodsInfo['truck_type'];
            if ($truckType !== $goodsInfo['truck_type']) $this->error('实物与虚拟不能混合下单！');
            // 限制购买数量
            if (isset($goods['limit_max_num']) && $goods['limit_max_num'] > 0) {
                $map = [['a.status', 'in', [2, 3, 4, 5]], ['b.goods_code', '=', $goods['code']], ['a.uid', '=', $this->uuid]];
                $buys = $this->app->db->name('StoreOrder')->alias('a')->join('store_order_item b', 'a.order_no=b.order_no')->where($map)->sum('b.stock_sales');
                if ($buys + $count > $goods['limit_max_num']) $this->error('超过限购数量');
            }
            // 限制购买身份
            if ($goodsInfo['limit_low_vip'] > $this->user['vip_number']) {
                $this->error('用户等级不够');
            }
            // 商品库存检查
            if ($goodsItem['stock_sales'] + $count > $goodsItem['stock_total']) {
                $this->error('商品库存不足');
            }
            // 商品折扣处理
            [$discountId, $discountRate] = [0, 100];
            if ($goodsInfo['discount_id'] > 0) {
                $map = ['status' => 1, 'deleted' => 0, 'id' => $goodsInfo['discount_id']];
                if ($items = $this->app->db->name('DataUserDiscount')->where($map)->value('items')) {
                    foreach (json_decode($items, true) as $vo) if ($vo['level'] == $this->user['vip_number']) {
                        [$discountId, $discountRate] = [$goodsInfo['discount_id'], $vo['discount']];
                    }
                }
            }
            // 订单详情处理
            $items[] = [
                'uid'             => $order['uid'],
                'order_no'        => $order['order_no'],
                // 商品信息字段
                'goods_name'      => $goodsInfo['name'],
                'goods_cover'     => $goodsInfo['cover'],
                'goods_sku'       => $goodsItem['goods_sku'],
                'goods_code'      => $goodsItem['goods_code'],
                'goods_spec'      => $goodsItem['goods_spec'],
                // 库存数量处理
                'stock_sales'     => $count,
                // 快递发货数据
                'truck_type'      => $goodsInfo['truck_type'],
                'truck_code'      => $goodsInfo['truck_code'],
                'truck_count'     => $goodsItem['number_express'] * $count,
                // 商品费用字段
                'price_market'    => $goodsItem['price_market'],
                'price_selling'   => $goodsItem['price_selling'],
                'total_market'    => $goodsItem['price_market'] * $count,
                'total_selling'   => $goodsItem['price_selling'] * $count,
                // 奖励金额积分
                'reward_balance'  => $goodsItem['reward_balance'] * $count,
                'reward_integral' => $goodsItem['reward_integral'] * $count,
                // 绑定用户等级
                'vip_name'        => $this->user['vip_name'],
                'vip_number'      => $this->user['vip_number'],
                // 是否入会礼包
                'vip_entry'       => $goodsInfo['vip_entry'],
                // 等级优惠方案
                'discount_id'     => $discountId,
                'discount_rate'   => $discountRate,
                'discount_amount' => $discountRate * $goodsItem['price_selling'] * $count / 100,
            ];
        }
        try {
            // 订单发货类型
            $order['truck_type'] = $truckType;
            $order['status'] = $truckType ? 2 : 1;
            // 统计商品数量
            $order['number_goods'] = array_sum(array_column($items, 'stock_sales'));
            // 统计商品金额
            $order['amount_goods'] = array_sum(array_column($items, 'total_selling'));
            // 优惠后的金额
            $order['amount_discount'] = array_sum(array_column($items, 'discount_amount'));
            // 订单随机免减
            $order['amount_reduct'] = OrderService::instance()->getReduct();
            if ($order['amount_reduct'] > $order['amount_goods']) {
                $order['amount_reduct'] = $order['amount_goods'];
            }
            // 统计订单金额
            $order['amount_real'] = $order['amount_discount'] - $order['amount_reduct'];
            $order['amount_total'] = $order['amount_goods'];
            // 写入商品数据
            $this->app->db->transaction(function () use ($order, $items) {
                $this->app->db->name('ShopOrder')->insert($order);
                $this->app->db->name('ShopOrderItem')->insertAll($items);
            });
            // 同步商品库存销量
            foreach ($codes as $code) GoodsService::instance()->syncStock($code);
            // 触发订单创建事件
            $this->app->event->trigger('ShopOrderCreate', $order['order_no']);
            // 组装订单商品数据
            $order['items'] = $items;
            // 返回处理成功数据
            $this->success('商品下单成功', $order);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error("商品下单失败，{$exception->getMessage()}");
        }
    }

    /**
     * 模拟计算订单运费
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function express()
    {
        $data = $this->_vali([
            'code.require'     => '地址不能为空',
            'order_no.require' => '单号不能为空',
        ]);
        // 用户收货地址
        $map = ['uid' => $this->uuid, 'code' => $data['code']];
        $addr = $this->app->db->name('DataUserAddress')->where($map)->find();
        if (empty($addr)) $this->error('收货地址异常');
        // 订单状态检查
        $map = ['uid' => $this->uuid, 'order_no' => $data['order_no']];
        $tCount = $this->app->db->name('ShopOrderItem')->where($map)->sum('truck_count');
        // 根据地址计算运费
        $map = ['status' => 1, 'deleted' => 0, 'order_no' => $data['order_no']];
        $tCode = $this->app->db->name('ShopOrderItem')->where($map)->column('truck_code');
        [$amount, , , $remark] = TruckService::instance()->amount($tCode, $addr['province'], $addr['city'], $tCount);
        $this->success('计算运费成功', ['amount' => $amount, 'remark' => $remark]);
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
            'code.require'     => '地址不能为空',
            'order_no.require' => '单号不能为空',
        ]);
        // 用户收货地址
        $map = ['uid' => $this->uuid, 'code' => $data['code'], 'deleted' => 0];
        $addr = $this->app->db->name('DataUserAddress')->where($map)->find();
        if (empty($addr)) $this->error('收货地址异常');
        // 订单状态检查
        $map = ['uid' => $this->uuid, 'order_no' => $data['order_no']];
        $order = $this->app->db->name('ShopOrder')->where($map)->whereIn('status', [1, 2])->find();
        $tCount = $this->app->db->name('ShopOrderItem')->where($map)->sum('truck_count');
        if (empty($order)) $this->error('不能修改地址');
        // 根据地址计算运费
        $map = ['status' => 1, 'deleted' => 0, 'order_no' => $data['order_no']];
        $tCodes = $this->app->db->name('ShopOrderItem')->where($map)->column('truck_code');
        [$amount, $tCount, $tCode, $remark] = TruckService::instance()->amount($tCodes, $addr['province'], $addr['city'], $tCount);
        // 创建订单发货信息
        $express = [
            'template_code'   => $tCode, 'template_count' => $tCount, 'uid' => $this->uuid,
            'template_remark' => $remark, 'template_amount' => $amount, 'status' => 1,
        ];
        $express['order_no'] = $data['order_no'];
        $express['address_code'] = $data['code'];
        $express['address_name'] = $addr['name'];
        $express['address_phone'] = $addr['phone'];
        $express['address_idcode'] = $addr['idcode'];
        $express['address_province'] = $addr['province'];
        $express['address_city'] = $addr['city'];
        $express['address_area'] = $addr['area'];
        $express['address_content'] = $addr['address'];
        $express['address_datetime'] = date('Y-m-d H:i:s');
        data_save('ShopOrderSend', $express, 'order_no');
        // 组装更新订单数据
        $update = ['status' => 2, 'amount_express' => $express['template_amount']];
        // 重新计算订单金额
        $update['amount_real'] = $order['amount_discount'] + $amount - $order['amount_reduct'];
        $update['amount_total'] = $order['amount_goods'] + $amount;
        // 支付金额不能为零
        if ($update['amount_real'] <= 0) $update['amount_real'] = 0.00;
        if ($update['amount_total'] <= 0) $update['amount_total'] = 0.00;
        // 更新用户订单数据
        $map = ['uid' => $this->uuid, 'order_no' => $data['order_no']];
        if ($this->app->db->name('ShopOrder')->where($map)->update($update) !== false) {
            // 触发订单确认事件
            $this->app->event->trigger('ShopOrderPerfect', $order['order_no']);
            // 返回处理成功数据
            $this->success('订单确认成功', ['order_no' => $order['order_no']]);
        } else {
            $this->error('订单确认失败');
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
        $data = $this->_vali([
            'order_no.require'     => '单号不能为空',
            'payment_code.require' => '参数不能为空',
            'payment_back.default' => '', # 支付回跳地址
        ]);
        $map = ['order_no' => $data['order_no']];
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) $this->error('读取订单失败');
        if ($order['status'] != 2) $this->error('不能发起支付');
        if ($order['payment_status'] > 0) $this->error('已经完成支付');
        try {
            $openid = '';
            if (in_array($this->type, [UserService::APITYPE_WXAPP, UserService::APITYPE_WECHAT])) {
                $openid = $this->user[UserService::TYPES[$this->type]['auth']] ?? '';
                if (empty($openid)) $this->error("无法创建支付");
            }
            // 返回订单数据及支付发起参数
            $type = $order['amount_real'] <= 0 ? 'empty' : $data['payment_code'];
            $param = PaymentService::instance($type)->create($openid, $order['order_no'], $order['amount_real'], '商城订单支付', '', $data['payment_back']);
            $order = $this->app->db->name('ShopOrder')->where($map)->find() ?: new \stdClass();
            $this->success('获取支付参数', ['order' => $order, 'param' => $param]);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
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
            'uid.value'        => $this->uuid,
            'order_no.require' => '单号不能为空',
        ]);
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) $this->error('读取订单失败');
        if (in_array($order['status'], [1, 2])) {
            $result = $this->app->db->name('ShopOrder')->where($map)->update([
                'status'          => 0,
                'cancel_status'   => 1,
                'cancel_remark'   => '用户主动取消订单！',
                'cancel_datetime' => date('Y-m-d H:i:s'),
            ]);
            if ($result !== false && OrderService::instance()->syncStock($order['order_no'])) {
                // 触发订单取消事件
                $this->app->event->trigger('ShopOrderCancel', $order['order_no']);
                // 返回处理成功数据
                $this->success('订单取消成功');
            } else {
                $this->error('订单取消失败');
            }
        } else {
            $this->error('订单不可取消');
        }
    }

    /**
     * 用户主动删除已取消的订单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function remove()
    {
        $map = $this->_vali([
            'uid.value'        => $this->uuid,
            'order_no.require' => '单号不能为空',
        ]);
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) $this->error('读取订单失败');
        if (in_array($order['status'], [0])) {
            $result = $this->app->db->name('ShopOrder')->where($map)->update([
                'status'           => 0,
                'deleted'          => 1,
                'deleted_remark'   => '用户主动删除订单！',
                'deleted_datetime' => date('Y-m-d H:i:s'),
            ]);
            if ($result !== false) {
                // 触发订单删除事件
                $this->app->event->trigger('ShopOrderRemove', $order['order_no']);
                // 返回处理成功数据
                $this->success('订单删除成功');
            } else {
                $this->error('订单删除失败');
            }
        } else {
            $this->error('订单不可删除');
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
            'uid.value'        => $this->uuid,
            'order_no.require' => '单号不能为空',
        ]);
        $order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($order)) $this->error('读取订单失败');
        if (in_array($order['status'], [4])) {
            if ($this->app->db->name('ShopOrder')->where($map)->update(['status' => 5]) !== false) {
                // 触发订单确认事件
                $this->app->event->trigger('ShopOrderConfirm', $order['order_no']);
                // 返回处理成功数据
                $this->success('订单确认成功');
            } else {
                $this->error('订单确认失败');
            }
        } else {
            $this->error('订单确认失败');
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
        $map = ['uid' => $this->uuid, 'deleted' => 0];
        $data = ['t0' => 0, 't1' => 0, 't2' => 0, 't3' => 0, 't4' => 0, 't5' => 0];
        $query = $this->app->db->name('ShopOrder')->fieldRaw('status,count(1) count');
        $query->where($map)->group('status')->select()->each(function ($item) use (&$data) {
            $data["t{$item['status']}"] = $item['count'];
        });
        $this->success('获取统计成功', $data);
    }

    /**
     * 物流追踪查询
     */
    public function track()
    {
        try {
            $data = $this->_vali([
                'code.require'   => '快递不能为空',
                'number.require' => '单号不能为空',
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