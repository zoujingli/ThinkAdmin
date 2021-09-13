<?php

namespace app\data\service;

use app\data\model\ShopGoods;
use app\data\model\ShopGoodsCate;
use app\data\model\ShopGoodsItem;
use app\data\model\ShopGoodsMark;
use app\data\model\ShopGoodsStock;
use app\data\model\ShopOrder;
use think\admin\extend\DataExtend;
use think\admin\Service;

/**
 * 商品数据服务
 * Class GoodsService
 * @package app\data\service
 */
class GoodsService extends Service
{

    /**
     * 获取商品标签数据
     * @return array
     */
    public function getMarkData(): array
    {
        $map = ['status' => 1];
        return ShopGoodsMark::mk()->where($map)->order('sort desc,id desc')->column('name');
    }

    /**
     * 获取分类数据
     * @param string $type 数据格式 arr2tree | arr2table
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCateTree(string $type = 'arr2tree'): array
    {
        $query = ShopGoodsCate::mk()->where(['deleted' => 0, 'status' => 1])->order('sort desc,id desc');
        return DataExtend::$type($query->withoutField('sort,status,deleted,create_at')->select()->toArray());
    }

    /**
     * 获取分类数据
     * @param boolean $simple 简化数据
     * @return array
     */
    public function getCateData(bool $simple = true): array
    {
        $cates = ShopGoodsCate::mk()->where(['status' => 1, 'deleted' => 0])->column('id,pid,name', 'id');
        foreach ($cates as $cate) if (isset($cates[$cate['pid']])) $cates[$cate['id']]['parent'] =& $cates[$cate['pid']];
        foreach ($cates as $key => $cate) {
            $id = $cate['id'];
            $cates[$id]['ids'][] = $cate['id'];
            $cates[$id]['names'][] = $cate['name'];
            while (isset($cate['parent']) && $cate = $cate['parent']) {
                $cates[$id]['ids'][] = $cate['id'];
                $cates[$id]['names'][] = $cate['name'];
            }
            $cates[$id]['ids'] = array_reverse($cates[$id]['ids']);
            $cates[$id]['names'] = array_reverse($cates[$id]['names']);
            if (isset($pky) && $simple && in_array($cates[$pky]['name'], $cates[$id]['names'])) {
                unset($cates[$pky]);
            }
            $pky = $key;
        }
        return $cates;
    }

    /**
     * 更新商品库存数据
     * @param string $code
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function stock(string $code): bool
    {
        // 商品入库统计
        $query = ShopGoodsStock::mk()->field('goods_code,goods_spec,ifnull(sum(goods_stock),0) stock_total');
        $stockList = $query->where(['goods_code' => $code])->group('goods_code,goods_spec')->select()->toArray();
        // 商品销量统计
        $query = ShopOrder::mk()->alias('a')->field('b.goods_code,b.goods_spec,ifnull(sum(b.stock_sales),0) stock_sales');
        $query->leftJoin('shop_order_item b', 'a.order_no=b.order_no')->where("b.goods_code='{$code}' and a.status>0 and a.deleted_status<1");
        $salesList = $query->group('b.goods_code,b.goods_spec')->select()->toArray();
        // 组装更新数据
        $dataList = [];
        foreach (array_merge($stockList, $salesList) as $vo) {
            $key = "{$vo['goods_code']}@@{$vo['goods_spec']}";
            $dataList[$key] = isset($dataList[$key]) ? array_merge($dataList[$key], $vo) : $vo;
            if (empty($dataList[$key]['stock_sales'])) $dataList[$key]['stock_sales'] = 0;
            if (empty($dataList[$key]['stock_total'])) $dataList[$key]['stock_total'] = 0;
        }
        unset($salesList, $stockList);
        // 更新商品规格销量及库存
        foreach ($dataList as $vo) {
            $map = ['goods_code' => $code, 'goods_spec' => $vo['goods_spec']];
            $set = ['stock_total' => $vo['stock_total'], 'stock_sales' => $vo['stock_sales']];
            ShopGoodsItem::mk()->where($map)->update($set);
        }
        // 更新商品主体销量及库存
        ShopGoods::mk()->where(['code' => $code])->update([
            'stock_total'   => intval(array_sum(array_column($dataList, 'stock_total'))),
            'stock_sales'   => intval(array_sum(array_column($dataList, 'stock_sales'))),
            'stock_virtual' => ShopGoodsItem::mk()->where(['goods_code' => $code])->sum('number_virtual'),
        ]);
        return true;
    }

    /**
     * 商品数据绑定
     * @param array $data 商品主数据
     * @param boolean $simple 简化数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function bindData(array &$data = [], bool $simple = true): array
    {
        [$cates, $codes] = [$this->getCateData(), array_unique(array_column($data, 'code'))];
        $marks = ShopGoodsMark::mk()->where(['status' => 1])->column('name');
        $items = ShopGoodsItem::mk()->whereIn('goods_code', $codes)->where(['status' => 1])->select()->toArray();
        foreach ($data as &$vo) {
            [$vo['marks'], $vo['cateids'], $vo['cateinfo']] = [str2arr($vo['marks'], ',', $marks), str2arr($vo['cateids']), []];
            [$vo['slider'], $vo['specs'], $vo['items']] = [str2arr($vo['slider'], '|'), json_decode($vo['data_specs'], true), []];
            foreach ($cates as $cate) if (in_array($cate['id'], $vo['cateids'])) $vo['cateinfo'] = $cate;
            foreach ($items as $item) if ($item['goods_code'] === $vo['code']) $vo['items'][] = $item;
            if ($simple) unset($vo['marks'], $vo['sort'], $vo['status'], $vo['deleted'], $vo['data_items'], $vo['data_specs'], $vo['cateinfo']['parent']);
        }
        return $data;
    }

}