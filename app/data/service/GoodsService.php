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
     * 获取分类数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCateList(): array
    {
        $map = ['deleted' => 0, 'status' => 1];
        $query = $this->app->db->name('ShopGoodsCate');
        $query->where($map)->order('sort desc,id desc');
        $query->withoutField('sort,status,deleted,create_at');
        return DataExtend::arr2tree($query->select()->toArray());
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