<?php

namespace app\data\service;

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
     * 更新商品库存数据
     * @param string $code
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function syncStock(string $code): bool
    {
        // 商品入库统计
        $query = $this->app->db->name('ShopGoodsStock');
        $query->field('goods_code,goods_spec,ifnull(sum(goods_stock),0) stock_total');
        $stockList = $query->where(['goods_code' => $code])->group('goods_code,goods_spec')->select()->toArray();
        // 商品销量统计
        $query = $this->app->db->table('shop_order a')->field('b.goods_code,b.goods_spec,ifnull(sum(b.stock_sales),0) stock_sales');
        $query->leftJoin('shop_order_item b', 'a.order_no=b.order_no')->where([['b.goods_code', '=', $code], ['a.status', 'in', [1, 2, 3, 4, 5]]]);
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
            $this->app->db->name('ShopGoodsItem')->where($map)->update($set);
        }
        // 更新商品主体销量及库存
        $this->app->db->name('ShopGoods')->where(['code' => $code])->update([
            'stock_total'   => intval(array_sum(array_column($dataList, 'stock_total'))),
            'stock_sales'   => intval(array_sum(array_column($dataList, 'stock_sales'))),
            'stock_virtual' => $this->app->db->name('ShopGoodsItem')->where(['goods_code' => $code])->sum('number_virtual'),
        ]);
        return true;
    }

    /**
     * 获取分类数据
     * @param string $type 操作函数
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCateList(string $type = 'arr2tree'): array
    {
        $map = ['deleted' => 0, 'status' => 1];
        $query = $this->app->db->name('ShopGoodsCate')->where($map)->order('sort desc,id desc');
        $cates = DataExtend::$type($query->withoutField('sort,status,deleted,create_at')->select()->toArray());
        if ($type === 'arr2table') foreach ($cates as &$vo) {
            $vo['sat'] = $vo['spt'] !== $this->getCateLevel() - 1 ? 'disabled' : '';
        }
        return $cates;
    }

    /**
     * 获取商品标签数据
     * @return array
     */
    public function getMarkList(): array
    {
        $map = ['status' => 1];
        $query = $this->app->db->name('ShopGoodsMark');
        return $query->where($map)->order('sort desc,id desc')->column('name');
    }

    /**
     * 商品数据绑定
     * @param array $data 商品主数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function buildItemData(array &$data = []): array
    {
        $cates = $this->app->db->name('ShopGoodsCate')->column('id,pid,name', 'id');
        foreach ($cates as $cate) if (isset($cates[$cate['pid']])) {
            $cates[$cate['id']]['parent'] =& $cates[$cate['pid']];
        }
        $codes = array_unique(array_column($data, 'code'));
        $query = $this->app->db->name('ShopGoodsItem')->withoutField('id,status,create_at');
        $items = $query->whereIn('goods_code', $codes)->where(['status' => 1])->select()->toArray();
        $marks = $this->app->db->name('ShopGoodsMark')->where(['status' => 1])->column('name');
        foreach ($data as &$vo) {
            $vo['marks'] = str2arr($vo['mark'], ',', $marks);
            $vo['cates'] = $cates[$vo['cate']] ?? [];
            $vo['slider'] = explode('|', $vo['slider']);
            $vo['specs'] = json_decode($vo['data_specs'], true);
            $vo['items'] = [];
            foreach ($items as $item) if ($item['goods_code'] === $vo['code']) $vo['items'][] = $item;
            unset($vo['mark'], $vo['sort'], $vo['status'], $vo['deleted'], $vo['data_items'], $vo['data_specs']);
        }
        return $data;
    }

    /**
     * 最大分类级别
     * @return integer
     */
    public function getCateLevel(): int
    {
        return 3;
    }

}