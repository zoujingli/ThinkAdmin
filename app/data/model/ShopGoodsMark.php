<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 商城商品标题模型
 * Class ShopGoodsMark
 * @package app\data\model
 */
class ShopGoodsMark extends Model
{
    /**
     * 获取所有标签
     * @return array
     */
    public static function items(): array
    {
        $map = ['status' => 1];
        return static::mk()->where($map)->order('sort desc,id desc')->column('name');
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