<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 商城商品主模型
 * Class ShopGoods
 * @package app\data\model
 */
class ShopGoods extends Model
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