<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\store\service;

use think\Db;

/**
 * 商品数据服务支持
 * Class ProductService
 * @package app\goods\service
 */
class GoodsService
{

    /**
     * 主商品表数据处理
     * @param array $goodsList
     * @return array
     */
    public static function buildGoodsList(&$goodsList)
    {
        // 商品分类处理
        $cateField = 'id,pid,cate_title,cate_desc';
        $cateWhere = ['status' => '1', 'is_deleted' => '0'];
        $cateList = Db::name('StoreGoodsCate')->where($cateWhere)->order('sort asc,id desc')->column($cateField);
        // 商品品牌处理
        $brandWhere = ['status' => '1', 'is_deleted' => '0'];
        $brandField = 'id,brand_logo,brand_cover,brand_title,brand_desc,brand_detail';
        $brandList = Db::name('StoreGoodsBrand')->where($brandWhere)->order('sort asc,id desc')->column($brandField);
        // 无商品列表时
        if (empty($goodsList)) {
            return ['list' => $goodsList, 'cate' => $cateList, 'brand' => $brandList];
        }
        // 读取商品详情列表
        $specWhere = [['status', 'eq', '1'], ['is_deleted', 'eq', '0'], ['goods_id', 'in', array_column($goodsList, 'id')]];
        $specField = 'id,goods_id,goods_spec,goods_number,market_price,selling_price,goods_stock,goods_sale';
        $specList = Db::name('StoreGoodsList')->where($specWhere)->column($specField);
        foreach ($specList as $key => $spec) {
            foreach ($goodsList as $goods) {
                if ($goods['id'] === $spec['goods_id']) {
                    $specList[$key]['goods_title'] = $goods['goods_title'];
                }
            }
            if ($spec['goods_spec'] === 'default:default') {
                $specList[$key]['goods_spec_alias'] = '<span class="color-desc">默认规格</span>';
            } else {
                $specList[$key]['goods_spec_alias'] = str_replace([':', ','], [': ', ', '], $spec['goods_spec']);
            }
        }
        // 商品数据组装
        foreach ($goodsList as $key => $vo) {
            // 商品内容处理
            $goodsList[$key]['goods_content'] = $vo['goods_content'];
            // 商品品牌处理
            $goodsList[$key]['brand'] = isset($brandList[$vo['brand_id']]) ? $brandList[$vo['brand_id']] : [];
            // 商品分类关联
            $goodsList[$key]['cate'] = [];
            if (isset($cateList[$vo['cate_id']])) {
                $goodsList[$key]['cate'][] = ($tcate = $cateList[$vo['cate_id']]);
                while (isset($tcate['pid']) && $tcate['pid'] > 0 && isset($cateList[$tcate['pid']])) {
                    $goodsList[$key]['cate'][] = ($tcate = $cateList[$tcate['pid']]);
                }
                $goodsList[$key]['cate'] = array_reverse($goodsList[$key]['cate']);
            }
            // 商品详细列表关联
            $goodsList[$key]['spec'] = [];
            foreach ($specList as $spec) {
                if ($vo['id'] === $spec['goods_id']) {
                    $goodsList[$key]['spec'][] = $spec;
                }
            }
        }
        return ['list' => $goodsList, 'cate' => $cateList, 'brand' => $brandList];
    }

    /**
     * 同步更新商品库存及售出
     * @param int $goods_id 商品ID
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function syncGoodsStock($goods_id)
    {
        // 检查商品是否需要更新库存
        $map = ['id' => $goods_id, 'is_deleted' => '0'];
        if (!($goods = Db::name('StoreGoods')->where($map)->find())) {
            return ['code' => 0, 'msg' => '指定商品信息无法同步库存！'];
        }
        // 统计入库信息
        $stockField = 'goods_id,goods_spec,ifnull(sum(goods_stock), 0) goods_stock';
        $stockWhere = ['status' => '1', 'is_deleted' => '0', 'goods_id' => $goods_id];
        $stockList = (array)Db::name('StoreGoodsStock')->field($stockField)->where($stockWhere)->group('goods_id,goods_spec')->select();
        // 统计销售信息
        $saleField = 'goods_id,goods_spec,ifnull(sum(number), 0) goods_sale';
        $saleWhere = ['status' => '1', 'is_deleted' => '0', 'goods_id' => $goods_id];
        $saleList = (array)Db::name('StoreOrderGoods')->field($saleField)->where($saleWhere)->group('goods_id,goods_spec')->select();
        // 库存置零
        list($where, $total_sale) = [['goods_id' => $goods_id], 0];
        Db::name('StoreGoodsList')->where($where)->update(['goods_stock' => 0, 'goods_sale' => 0]);
        // 更新商品库存
        foreach ($stockList as $stock) {
            $where = ['goods_id' => $goods_id, 'goods_spec' => $stock['goods_spec']];
            Db::name('StoreGoodsList')->where($where)->update(['goods_stock' => $stock['goods_stock']]);
        }
        // 更新商品销量
        foreach ($saleList as $sale) {
            $total_sale += intval($sale['goods_sale']);
            $where = ['goods_id' => $goods_id, 'goods_spec' => $sale['goods_spec']];
            Db::name('StoreGoodsList')->where($where)->update(['goods_sale' => $sale['goods_sale']]);
        }
        return ['code' => 1, 'msg' => '同步商品库存成功！'];
    }

}