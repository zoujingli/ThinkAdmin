<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 商城商品规格模型
 * Class ShopGoodsItem
 * @package app\data\model
 */
class ShopGoodsItem extends Model
{
    /**
     * 格式化创建时间
     * @param string $value
     * @return string
     */
    public function getCreateAtAttr(string $value): string
    {
        return format_datetime($value);
    }
}