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

namespace app\goods\service;

use think\Db;

/**
 * 产品数据服务支持
 * Class ProductService
 * @package app\goods\service
 */
class ProductService
{

    /**
     * 主产品表数据处理
     * @param array $goodsList
     * @return array
     */
    public static function buildGoodsList(&$goodsList)
    {
        // 产品分类处理
        $cateField = 'id,pid,cate_title,cate_desc';
        $cateWhere = ['status' => '1', 'is_deleted' => '0'];
        $cateList = Db::name('GoodsCate')->where($cateWhere)->order('sort asc,id desc')->column($cateField);
        // 产品品牌处理
        $brandField = 'id,brand_logo,brand_cover,brand_title,brand_desc,brand_detail';
        $brandWhere = ['status' => '1', 'is_deleted' => '0'];
        $brandList = Db::name('GoodsBrand')->where($brandWhere)->order('sort asc,id desc')->column($brandField);
        // 无产品列表时
        if (empty($goodsList)) {
            return ['list' => $goodsList, 'cate' => $cateList, 'brand' => $brandList];
        }
        // 读取产品详情列表
        $specWhere = [['status', 'eq', '1'], ['is_deleted', 'eq', '0'], ['goods_id', 'in', array_column($goodsList, 'id')]];
        $specField = 'id,goods_id,goods_spec,goods_number,market_price,selling_price,goods_stock,goods_sale';
        $specList = Db::name('GoodsList')->where($specWhere)->column($specField);
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
        // 产品数据组装
        foreach ($goodsList as $key => $vo) {
            // 产品内容处理
            $goodsList[$key]['goods_content'] = htmlspecialchars_decode($vo['goods_content']);
            // 产品品牌处理
            $goodsList[$key]['brand'] = isset($brandList[$vo['brand_id']]) ? $brandList[$vo['brand_id']] : [];
            // 产品分类关联
            $goodsList[$key]['cate'] = [];
            if (isset($cateList[$vo['cate_id']])) {
                $goodsList[$key]['cate'][] = ($tcate = $cateList[$vo['cate_id']]);
                while (isset($tcate['pid']) && $tcate['pid'] > 0 && isset($cateList[$tcate['pid']])) {
                    $goodsList[$key]['cate'][] = ($tcate = $cateList[$tcate['pid']]);
                }
                $goodsList[$key]['cate'] = array_reverse($goodsList[$key]['cate']);
            }
            // 产品详细列表关联
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
     * 同步更新产品库存及售出（@todo 需要重新做库存统计）
     * @param int $goods_id 产品ID
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function syncGoodsStock($goods_id)
    {
        // 检查产品是否需要更新库存
        $map = ['id' => $goods_id, 'is_deleted' => '0'];
        if (!($goods = Db::name('Goods')->where($map)->find())) {
            return ['code' => 0, 'msg' => '指定产品信息无法同步库存！'];
        }
        // 统计入库信息
        $stockField = 'goods_id,goods_spec,ifnull(sum(goods_stock), 0) goods_stock';
        $stockWhere = ['status' => '1', 'is_deleted' => '0', 'goods_id' => $goods_id, 'mch_id' => $mch_id];
        $stockList = (array)Db::name('GoodsStock')->field($stockField)->where($stockWhere)->group('goods_id,goods_spec')->select();
        // 统计销售信息
        $saleField = 'goods_id,goods_spec,ifnull(sum(number), 0) goods_sale';
        $saleWhere = ['status' => '1', 'is_deleted' => '0', 'goods_id' => $goods_id, 'mch_id' => $mch_id];
        $saleList = (array)Db::name('StoreOrderList')->field($saleField)->where($saleWhere)->group('goods_id,goods_spec')->select();
        // 库存置零
        list($where, $total_stock, $total_sale) = [['goods_id' => $goods_id], 0, 0];
        Db::name('GoodsList')->where($where)->update(['goods_stock' => 0, 'goods_sale' => 0, 'mch_id' => $mch_id]);
        // 更新产品库存
        foreach ($stockList as $stock) {
            $total_stock += intval($stock['goods_stock']);
            $where = ['goods_id' => $goods_id, 'goods_spec' => $stock['goods_spec'], 'mch_id' => $mch_id];
            Db::name('GoodsList')->where($where)->update(['goods_stock' => $stock['goods_stock']]);
        }
        // 更新产品销量
        foreach ($saleList as $sale) {
            $total_sale += intval($sale['goods_sale']);
            $where = ['goods_id' => $goods_id, 'goods_spec' => $sale['goods_spec'], 'mch_id' => $mch_id];
            Db::name('GoodsList')->where($where)->update(['goods_sale' => $sale['goods_sale']]);
        }
        // 更新总库存及总销量
        $update = ['package_stock' => $total_stock, 'package_sale' => $total_sale, 'mch_id' => $mch_id];
        Db::name('Goods')->where(['id' => $goods_id])->update($update);
        return ['code' => 1, 'msg' => '同步产品库存成功！'];
    }

}