<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\store\service;

use think\Db;

/**
 * 商品数据管理
 * Class GoodsService
 * @package app\store\logic
 */
class GoodsService
{
    /**
     * 同步商品库存信息
     * @param integer $goodsId
     * @return boolean
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function syncStock($goodsId)
    {
        // 商品入库统计
        $fields = "goods_id,goods_spec,ifnull(sum(number_stock),0) number_stock";
        $stockList = Db::name('StoreGoodsStock')->field($fields)->where(['goods_id' => $goodsId])->group('goods_id,goods_spec')->select();
        // 商品销量统计
        $where = [['b.goods_id', 'eq', $goodsId], ['a.status', 'in', ['1', '2', '3', '4', '5']]];
        $fields = 'b.goods_id,b.goods_spec,ifnull(sum(b.number_goods),0) number_sales';
        $salesList = Db::table('store_order a')->field($fields)->leftJoin('store_order_list b', 'a.order_no=b.order_no')->where($where)->group('b.goods_id,b.goods_spec')->select();
        // 组装更新数据
        $dataList = [];
        foreach (array_merge($stockList, $salesList) as $vo) {
            $key = "{$vo['goods_id']}@@{$vo['goods_spec']}";
            $dataList[$key] = isset($dataList[$key]) ? array_merge($dataList[$key], $vo) : $vo;
            if (empty($dataList[$key]['number_sales'])) $dataList[$key]['number_sales'] = '0';
            if (empty($dataList[$key]['number_stock'])) $dataList[$key]['number_stock'] = '0';
        }
        unset($salesList, $stockList);
        // 更新商品规格销量及库存
        foreach ($dataList as $vo) Db::name('StoreGoodsList')->where([
            'goods_id'   => $goodsId,
            'goods_spec' => $vo['goods_spec'],
        ])->update([
            'number_stock' => $vo['number_stock'],
            'number_sales' => $vo['number_sales'],
        ]);
        // 更新商品主体销量及库存
        Db::name('StoreGoods')->where(['id' => $goodsId])->update([
            'number_stock' => intval(array_sum(array_column($dataList, 'number_stock'))),
            'number_sales' => intval(array_sum(array_column($dataList, 'number_sales'))),
        ]);
        return true;
    }

}
