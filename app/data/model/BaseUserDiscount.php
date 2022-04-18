<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 用户优惠方案模型
 * Class BaseUserDiscount
 * @package app\data\model
 */
class BaseUserDiscount extends Model
{
    /**
     * 格式化等级规则
     * @param mixed $value
     * @return mixed
     */
    public function getItemsAttr($value)
    {
        return empty($value) ? $value : json_decode($value, true);
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