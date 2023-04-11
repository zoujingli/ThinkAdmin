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

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\model\BaseUserPayment;
use app\data\model\DataUser;
use app\data\model\DataUserAddress;
use app\data\model\ShopGoods;
use app\data\model\ShopGoodsItem;
use app\data\model\ShopOrder;
use app\data\model\ShopOrderItem;
use app\data\model\ShopOrderSend;
use app\data\service\ExpressService;
use app\data\service\GoodsService;
use app\data\service\OrderService;
use app\data\service\PaymentService;
use app\data\service\UserAdminService;
use Exception;
use stdClass;
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
        $map = ['uuid' => $this->uuid, 'deleted_status' => 0];
        $query = ShopOrder::mQuery()->in('status')->equal('order_no');
        $result = $query->where($map)->order('id desc')->page(true, false, false, 20);
        if (count($result['list']) > 0) OrderService::buildData($result['list']);
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
        // 检查用户状态
        $this->checkUserStatus();
        // 商品规则
        $rules = $this->request->post('items', '');
        if (empty($rules)) $this->error('商品不能为空');
        // 订单数据
        [$items, $order, $truckType, $allowPayments] = [[], [], -1, null];
        $order['uuid'] = $this->uuid;
        $order['order_no'] = CodeExtend::uniqidDate(18, 'N');
        // 代理处理
        $order['puid1'] = input('from', $this->user['pid1']);
        if ($order['puid1'] == $this->uuid) $order['puid1'] = 0;
        if ($order['puid1'] > 0) {
            $map = ['id' => $order['puid1'], 'status' => 1];
            $order['puid2'] = DataUser::mk()->where($map)->value('pid2');
            if (is_null($order['puid2'])) $this->error('代理异常');
        }
        // 订单商品处理
        foreach (explode('||', $rules) as $rule) {
            [$code, $spec, $count] = explode('@', $rule);
            // 商品信息检查
            $goodsInfo = ShopGoods::mk()->where(['code' => $code, 'status' => 1, 'deleted' => 0])->find();
            $goodsItem = ShopGoodsItem::mk()->where(['status' => 1, 'goods_code' => $code, 'goods_spec' => $spec])->find();
            if (empty($goodsInfo) || empty($goodsItem)) $this->error('商品查询异常');
            // 商品类型检查
            if ($truckType < 0) $truckType = $goodsInfo['truck_type'];
            if ($truckType !== $goodsInfo['truck_type']) $this->error('不能混合下单');
            // 限制购买数量
            if (isset($goodsInfo['limit_max_num']) && $goodsInfo['limit_max_num'] > 0) {
                $map = [['a.uuid', '=', $this->uuid], ['a.status', 'in', [2, 3, 4, 5]], ['b.goods_code', '=', $goodsInfo['code']]];
                $table = ShopOrderItem::mk()->getTable();
                $buys = ShopOrder::mk()->alias('a')->join("{$table} b", 'a.order_no=b.order_no')->where($map)->sum('b.stock_sales');
                if ($buys + $count > $goodsInfo['limit_max_num']) $this->error('超过限购数量');
            }
            // 限制购买身份
            if ($goodsInfo['limit_low_vip'] > $this->user['vip_code']) $this->error('用户等级不够');
            // 商品库存检查
            if ($goodsItem['stock_sales'] + $count > $goodsItem['stock_total']) $this->error('商品库存不足');
            // 支付支付处理
            $_allowPayments = [];
            foreach (str2arr($goodsInfo['payment']) as $code) {
                if (is_null($allowPayments) || in_array($code, $allowPayments)) $_allowPayments[] = $code;
            }
            if (empty($_allowPayments)) {
                $this->error('订单无法统一支付');
            } else {
                $allowPayments = $_allowPayments;
            }
            // 商品折扣处理
            [$discountId, $discountRate] = OrderService::discount($goodsInfo['discount_id'], $this->user['vip_code']);
            // 订单详情处理
            $items[] = [
                'uuid'            => $order['uuid'],
                'order_no'        => $order['order_no'],
                // 商品信息字段
                'goods_name'      => $goodsInfo['name'],
                'goods_cover'     => $goodsInfo['cover'],
                'goods_payment'   => $goodsInfo['payment'],
                'goods_sku'       => $goodsItem['goods_sku'],
                'goods_code'      => $goodsItem['goods_code'],
                'goods_spec'      => $goodsItem['goods_spec'],
                // 库存数量处理
                'stock_sales'     => $count,
                // 快递发货数据
                'truck_type'      => $goodsInfo['truck_type'],
                'truck_code'      => $goodsInfo['truck_code'],
                'truck_number'    => $goodsInfo['rebate_type'] > 0 ? $goodsItem['number_express'] * $count : 0,
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
                'vip_code'        => $this->user['vip_code'],
                // 是否入会礼包
                'vip_entry'       => $goodsInfo['vip_entry'],
                'vip_upgrade'     => $goodsInfo['vip_upgrade'],
                // 是否参与返利
                'rebate_type'     => $goodsInfo['rebate_type'],
                'rebate_amount'   => $goodsInfo['rebate_type'] > 0 ? $goodsItem['price_selling'] * $count : 0,
                // 等级优惠方案
                'discount_id'     => $discountId,
                'discount_rate'   => $discountRate,
                'discount_amount' => $discountRate * $goodsItem['price_selling'] * $count / 100,
            ];
        }
        try {
            $order['payment_allow'] = arr2str($allowPayments);
            $order['rebate_amount'] = array_sum(array_column($items, 'rebate_amount'));
            $order['reward_balance'] = array_sum(array_column($items, 'reward_balance'));

            // 订单发货类型
            $order['status'] = $truckType ? 1 : 2;
            $order['truck_type'] = $truckType;
            // 统计商品数量
            $order['number_goods'] = array_sum(array_column($items, 'stock_sales'));
            $order['number_express'] = array_sum(array_column($items, 'truck_number'));
            // 统计商品金额
            $order['amount_goods'] = array_sum(array_column($items, 'total_selling'));
            // 优惠后的金额
            $order['amount_discount'] = array_sum(array_column($items, 'discount_amount'));
            // 订单随机免减
            $order['amount_reduct'] = OrderService::getReduct();
            if ($order['amount_reduct'] > $order['amount_goods']) {
                $order['amount_reduct'] = $order['amount_goods'];
            }
            // 统计订单金额
            $order['amount_real'] = $order['amount_discount'] - $order['amount_reduct'];
            $order['amount_total'] = $order['amount_goods'];
            // 写入商品数据
            $this->app->db->transaction(function () use ($order, $items) {
                ShopOrder::mk()->insert($order);
                ShopOrderItem::mk()->insertAll($items);
            });
            // 同步商品库存销量
            foreach (array_unique(array_column($items, 'goods_code')) as $code) {
                GoodsService::stock($code);
            }
            // 触发订单创建事件
            $this->app->event->trigger('ShopOrderCreate', $order['order_no']);
            // 组装订单商品数据
            $order['items'] = $items;
            // 返回处理成功数据
            $this->success('商品下单成功', $order);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->error("商品下单失败，{$exception->getMessage()}");
        }
    }

    /**
     * 获取用户折扣
     */
    public function discount()
    {
        $data = $this->_vali(['discount.require' => '折扣编号不能为空！']);
        [, $rate] = OrderService::discount(intval($data['discount']), $this->user['vip_code']);
        $this->success('获取用户折扣', ['rate' => $rate]);
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
            'uuid.value'       => $this->uuid,
            'code.require'     => '地址不能为空',
            'order_no.require' => '单号不能为空',
        ]);

        // 用户收货地址
        $map = ['uuid' => $this->uuid, 'code' => $data['code']];
        $addr = DataUserAddress::mk()->where($map)->find();
        if (empty($addr)) $this->error('收货地址异常');

        // 订单状态检查
        $map = ['uuid' => $this->uuid, 'order_no' => $data['order_no']];
        $tCount = ShopOrderItem::mk()->where($map)->sum('truck_number');

        // 根据地址计算运费
        $map = ['status' => 1, 'deleted' => 0, 'order_no' => $data['order_no']];
        $tCode = ShopOrderItem::mk()->where($map)->column('truck_code');
        [$amount, , , $remark] = ExpressService::amount($tCode, $addr['province'], $addr['city'], $tCount);
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
            'uuid.value'       => $this->uuid,
            'code.require'     => '地址不能为空',
            'order_no.require' => '单号不能为空',
        ]);

        // 用户收货地址
        $map = ['uuid' => $this->uuid, 'code' => $data['code'], 'deleted' => 0];
        $addr = DataUserAddress::mk()->where($map)->find();
        if (empty($addr)) $this->error('收货地址异常');

        // 订单状态检查
        $map1 = ['uuid' => $this->uuid, 'order_no' => $data['order_no']];
        $order = ShopOrder::mk()->where($map1)->whereIn('status', [1, 2])->find();
        if (empty($order)) $this->error('不能修改地址');
        if (empty($order['truck_type'])) $this->success('无需快递配送', ['order_no' => $order['order_no']]);

        // 根据地址计算运费
        $map2 = ['status' => 1, 'deleted' => 0, 'order_no' => $data['order_no']];
        $tCount = ShopOrderItem::mk()->where($map1)->sum('truck_number');
        $tCodes = ShopOrderItem::mk()->where($map2)->column('truck_code');
        [$amount, $tCount, $tCode, $remark] = ExpressService::amount($tCodes, $addr['province'], $addr['city'], $tCount);

        // 创建订单发货信息
        $express = [
            'template_code'   => $tCode, 'template_count' => $tCount, 'uuid' => $this->uuid,
            'template_remark' => $remark, 'template_amount' => $amount, 'status' => 1,
        ];
        $express['order_no'] = $data['order_no'];
        $express['address_code'] = $data['code'];
        $express['address_datetime'] = date('Y-m-d H:i:s');

        // 收货人信息
        $express['address_name'] = $addr['name'];
        $express['address_phone'] = $addr['phone'];
        $express['address_idcode'] = $addr['idcode'];
        $express['address_idimg1'] = $addr['idimg1'];
        $express['address_idimg2'] = $addr['idimg2'];

        // 收货地址信息
        $express['address_province'] = $addr['province'];
        $express['address_city'] = $addr['city'];
        $express['address_area'] = $addr['area'];
        $express['address_content'] = $addr['address'];

        ShopOrderSend::mUpdate($express, 'order_no');
        data_save(ShopOrderSend::class, $express, 'order_no');
        // 组装更新订单数据
        $update = ['status' => 2, 'amount_express' => $express['template_amount']];
        // 重新计算订单金额
        $update['amount_real'] = $order['amount_discount'] + $amount - $order['amount_reduct'];
        $update['amount_total'] = $order['amount_goods'] + $amount;
        // 支付金额不能为零
        if ($update['amount_real'] <= 0) $update['amount_real'] = 0.00;
        if ($update['amount_total'] <= 0) $update['amount_total'] = 0.00;
        // 更新用户订单数据
        $map = ['uuid' => $this->uuid, 'order_no' => $data['order_no']];
        if (ShopOrder::mk()->where($map)->update($update) !== false) {
            // 触发订单确认事件
            $this->app->event->trigger('ShopOrderPerfect', $order['order_no']);
            // 返回处理成功数据
            $this->success('订单确认成功', ['order_no' => $order['order_no']]);
        } else {
            $this->error('订单确认失败');
        }
    }

    /**
     * 获取支付支付数据
     */
    public function channel()
    {
        $data = $this->_vali(['uuid.value' => $this->uuid, 'order_no.require' => '单号不能为空']);
        $payments = ShopOrder::mk()->where($data)->value('payment_allow');
        if (empty($payments)) $this->error('获取订单支付参数失败');
        // 读取支付通道配置
        $query = BaseUserPayment::mk()->where(['status' => 1, 'deleted' => 0]);
        $query->whereIn('code', str2arr($payments))->whereIn('type', PaymentService::getTypeApi($this->type));
        $result = $query->order('sort desc,id desc')->column('type,code,name,cover,content,remark', 'code');
        foreach ($result as &$vo) $vo['content'] = ['voucher_qrcode' => json_decode($vo['content'])->voucher_qrcode ?? ''];
        $this->success('获取支付参数数据', array_values($result));
    }

    /**
     * 获取订单支付状态
     * @throws \think\db\exception\DbException
     */
    public function payment()
    {
        $data = $this->_vali([
            'uuid.value'            => $this->uuid,
            'order_no.require'      => '单号不能为空',
            'order_remark.default'  => '',
            'payment_code.require'  => '支付不能为空',
            'payment_back.default'  => '', # 支付回跳地址
            'payment_image.default' => '', # 支付凭证图片
        ]);
        [$map, $order] = $this->getOrderData();
        if ($order['status'] !== 2) $this->error('不能发起支付');
        if ($order['payment_status'] > 0) $this->error('已经完成支付');
        // 更新订单备注
        if (!empty($data['order_remark'])) {
            ShopOrder::mk()->where($map)->update([
                'order_remark' => $data['order_remark'],
            ]);
        }
        // 自动处理用户字段
        $openid = '';
        if (in_array($this->type, [UserAdminService::API_TYPE_WXAPP, UserAdminService::API_TYPE_WECHAT])) {
            $openid = $this->user[UserAdminService::TYPES[$this->type]['auth']] ?? '';
            if (empty($openid)) $this->error("发起支付失败");
        }
        try {
            // 返回订单数据及支付发起参数
            $type = $order['amount_real'] <= 0 ? 'empty' : $data['payment_code'];
            $param = PaymentService::instance($type)->create($openid, $order['order_no'], $order['amount_real'], '商城订单支付', '', $data['payment_back'], $data['payment_image']);
            $this->success('获取支付参数', ['order' => ShopOrder::mk()->where($map)->find() ?: new stdClass(), 'param' => $param]);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (Exception $exception) {
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
        [$map, $order] = $this->getOrderData();
        if (in_array($order['status'], [1, 2, 3])) {
            $result = ShopOrder::mk()->where($map)->update([
                'status'          => 0,
                'cancel_status'   => 1,
                'cancel_remark'   => '用户主动取消订单',
                'cancel_datetime' => date('Y-m-d H:i:s'),
            ]);
            if ($result !== false && OrderService::stock($order['order_no'])) {
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
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        [$map, $order] = $this->getOrderData();
        if (empty($order)) $this->error('读取订单失败');
        if ($order['status'] == 0) {
            $result = ShopOrder::mk()->where($map)->update([
                'status'           => 0,
                'deleted_status'   => 1,
                'deleted_remark'   => '用户主动删除订单',
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
     * @throws \think\db\exception\DbException
     */
    public function confirm()
    {
        [$map, $order] = $this->getOrderData();
        if ($order['status'] == 5) {
            if (ShopOrder::mk()->where($map)->update(['status' => 6]) !== false) {
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
     * 获取输入订单
     * @return array [map, order]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function getOrderData(): array
    {
        $map = $this->_vali([
            'uuid.value'       => $this->uuid,
            'order_no.require' => '单号不能为空',
        ]);
        $order = ShopOrder::mk()->where($map)->find();
        if (empty($order)) $this->error('读取订单失败');
        return [$map, $order];
    }

    /**
     * 订单状态统计
     */
    public function total()
    {
        $data = ['t0' => 0, 't1' => 0, 't2' => 0, 't3' => 0, 't4' => 0, 't5' => 0, 't6' => 0];
        $query = ShopOrder::mk()->where(['uuid' => $this->uuid, 'deleted_status' => 0]);
        foreach ($query->field('status,count(1) count')->group('status')->cursor() as $item) {
            $data["t{$item['status']}"] = $item['count'];
        }
        $this->success('获取订单统计', $data);
    }

    /**
     * 物流追踪查询
     */
    public function track()
    {
        try {
            $data = $this->_vali([
                'code.require'   => '快递不能为空',
                'number.require' => '单号不能为空'
            ]);
            $result = ExpressService::query($data['code'], $data['number']);
            empty($result['code']) ? $this->error($result['info']) : $this->success('快递追踪信息', $result);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}