<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 用户支付参数模型
 * Class BaseUserPayment
 * @package app\data\model
 */
class BaseUserPayment extends Model
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