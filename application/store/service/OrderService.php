<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\store\service;

use service\DataService;
use service\ToolsService;
use think\Db;

/**
 * 商城订单服务
 * Class OrderService
 * @package app\store
 */
class OrderService
{
    /**
     * 商城创建订单
     * @param int $mid 会员ID
     * @param string $params 商品参数规格 (商品ID@商品规格@购买数量;商品ID@商品规格@购买数量)
     * @param int $addressId 地址记录ID
     * @param int $expressId 快递记录ID
     * @param string $orderDesc 订单描述
     * @param integer $orderType 订单类型
     * @param string $from 订单来源
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function create($mid, $params, $addressId, $expressId, $orderDesc = '', $orderType = 1, $from = 'wechat')
    {
        // 会员数据获取与检验
        if (!($member = Db::name('StoreMember')->where(['id' => $mid])->find())) {
            return ['code' => 0, 'msg' => '会员数据处理异常，请刷新重试！'];
        }
        // 订单数据生成
        list($order_no, $orderList) = [DataService::createSequence(10, 'ORDER'), []];
        $order = ['mid' => $mid, 'order_no' => $order_no, 'real_price' => 0, 'goods_price' => 0, 'desc' => $orderDesc, 'type' => $orderType, 'from' => $from];
        foreach (explode(';', trim($params, ',;@')) as $param) {
            list($goods_id, $goods_spec, $number) = explode('@', "{$param}@@");
            $item = ['mid' => $mid, 'type' => $orderType, 'order_no' => $order_no, 'goods_id' => $goods_id, 'goods_spec' => $goods_spec, 'goods_number' => $number];
            $goodsResult = self::buildOrderData($item, $order, $orderList, 'selling_price');
            if (empty($goodsResult['code'])) {
                return $goodsResult;
            }
        }
        // 生成快递信息
        $expressResult = self::buildExpressData($order, $addressId, $expressId);
        if (empty($expressResult['code'])) {
            return $expressResult;
        }
        try {
            // 写入订单信息
            Db::transaction(function () use ($order, $orderList, $expressResult) {
                Db::name('StoreOrder')->insert($order); // 主订单信息
                Db::name('StoreOrderGoods')->insertAll($orderList); // 订单关联的商品信息
                Db::name('storeOrderExpress')->insert($expressResult['data']); // 快递信息
            });
            // 同步商品库存列表
            foreach (array_unique(array_column($orderList, 'goods_id')) as $stock_goods_id) {
                GoodsService::syncGoodsStock($stock_goods_id);
            }
        } catch (\Exception $e) {
            return ['code' => 0, 'msg' => '商城订单创建失败，请稍候再试！' . $e->getLine() . $e->getFile() . $e->getMessage()];
        }
        return ['code' => 1, 'msg' => '商城订单创建成功！', 'order_no' => $order_no];
    }

    /**
     * 生成订单快递数据
     * @param array $order 订单主表记录
     * @param int $address_id 会员地址ID
     * @param int $express_id 快递信息ID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function buildExpressData(&$order, $address_id, $express_id)
    {
        // 收货地址处理
        $addressWhere = ['mid' => $order['mid'], 'id' => $address_id, 'status' => '1', 'is_deleted' => '0'];
        $addressField = 'username express_username,phone express_phone,province express_province,city express_city,area express_area,address express_address';
        if (!($address = Db::name('StoreMemberAddress')->field($addressField)->where($addressWhere)->find())) {
            return ['code' => 0, 'msg' => '收货地址数据异常！'];
        }
        // 物流信息查询
        $expressField = 'express_title,express_code';
        $expressWhere = ['id' => $express_id, 'status' => '1', 'is_deleted' => '0'];
        if (!($express = Db::name('StoreExpress')->field($expressField)->where($expressWhere)->find())) {
            return ['code' => 0, 'msg' => '快递公司数据异常！'];
        }
        // @todo 运费计算处理
        // $order['freight_price'] = '0.00';
        // $order['real_price'] += floatval($order['freight_price']);
        $extend = ['mid' => $order['mid'], 'order_no' => $order['order_no'], 'type' => $order['type']];
        return ['code' => 1, 'data' => array_merge($address, $express, $extend), 'msg' => '生成快递信息成功！'];
    }

    /**
     * 订单数据生成
     * @param array $item 订单单项参数
     * (mid,type,order_no,goods_id,goods_spec,goods_number)
     * @param array $order 订单主表
     * @param array $orderList 订单详细表
     * @param string $price_field 实际计算单价字段
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function buildOrderData($item, &$order, &$orderList, $price_field = 'selling_price')
    {
        list($mid, $type, $order_no, $goods_id, $goods_spec, $number) = [
            $item['mid'], $item['type'], $item['order_no'], $item['goods_id'], $item['goods_spec'], $item['goods_number'],
        ];
        // 商品主体信息
        $goodsField = 'goods_title,goods_logo,goods_image';
        $goodsWhere = ['id' => $goods_id, 'status' => '1', 'is_deleted' => '0'];
        if (!($goods = Db::name('StoreGoods')->field($goodsField)->where($goodsWhere)->find())) {
            return ['code' => 0, 'msg' => "无效的商品信息！", 'data' => "{$goods_id}, {$goods_spec}, {$number}"];
        }
        // 商品规格信息
        $specField = 'goods_id,goods_spec,market_price,selling_price,goods_stock,goods_sale';
        $specWhere = ['status' => '1', 'is_deleted' => '0', 'goods_id' => $goods_id, 'goods_spec' => $goods_spec];
        if (!($goodsSpec = Db::name('StoreGoodsList')->field($specField)->where($specWhere)->find())) {
            return ['code' => 0, 'msg' => '无效的商品规格信息！', 'data' => "{$goods_id}, {$goods_spec}, {$number}"];
        }
        // 商品库存检查
        if ($goodsSpec['goods_stock'] - $goodsSpec['goods_sale'] < $number) {
            return ['code' => 0, 'msg' => '商品库存不足，请更换其它商品！', 'data' => "{$goods_id}, {$goods_spec}, {$number}"];
        }
        // 订单价格处理
        $goodsSpec['price_field'] = $price_field;
        $orderList[] = array_merge($goods, $goodsSpec, ['mid' => $mid, 'number' => $number, 'order_no' => $order_no, 'type' => $type]);
        $order['goods_price'] += floatval($goodsSpec[$price_field]) * $number;
        $order['real_price'] += floatval($goodsSpec[$price_field]) * $number;
        return ['code' => 1, 'msg' => '商品添加到订单成功！'];
    }

    /**
     * 订单主表数据处理
     * @param array $list
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function buildOrderList(&$list)
    {
        $mids = array_unique(array_column($list, 'mid'));
        $orderNos = array_unique(array_column($list, 'order_no'));
        $memberList = Db::name("StoreMember")->whereIn('id', $mids)->select();
        $goodsList = Db::name('StoreOrderGoods')->whereIn('order_no', $orderNos)->select();
        $expressList = Db::name('StoreOrderExpress')->whereIn('order_no', $orderNos)->select();
        foreach ($list as $key => $vo) {
            list($list[$key]['member'], $list[$key]['goods'], $list[$key]['express']) = [[], [], []];
            foreach ($memberList as $member) {
                $member['nickname'] = ToolsService::emojiDecode($member['nickname']);
                ($vo['mid'] === $member['id']) && $list[$key]['member'] = $member;
            }
            foreach ($expressList as $express) {
                ($vo['order_no'] === $express['order_no']) && $list[$key]['express'] = $express;
            }
            foreach ($goodsList as $goods) {
                if ($goods['goods_spec'] === 'default:default') {
                    $goods['goods_spec_alias'] = '<span class="color-desc">默认规格</span>';
                } else {
                    $goods['goods_spec_alias'] = str_replace([':', ','], ['：', '，'], $goods['goods_spec']);
                }
                ($vo['order_no'] === $goods['order_no']) && $list[$key]['goods'][] = $goods;
            }
        }
        return $list;
    }

}