<?php

namespace app\data\model;

use think\admin\Model;
use think\model\relation\HasMany;

/**
 * 商城商品规格模型
 * Class ShopGoodsItem
 * @package app\data\model
 */
class ShopGoodsItem extends Model
{

    /**
     * 关联商品规格
     * @return \think\model\relation\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(ShopGoodsItem::class, 'goods_code', 'code');
    }

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