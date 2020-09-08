<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 商品数据服务
 * Class GoodsService
 * @package app\data\service
 */
class GoodsService extends Service
{

    /**
     * 最大分类级别
     * @return integer
     */
    public function getCateLevel(): int
    {
        return 3;
    }

}