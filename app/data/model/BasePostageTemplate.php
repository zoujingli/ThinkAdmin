<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 快递模板模型
 * Class BasePostageTemplate
 * @package app\data\model
 */
class BasePostageTemplate extends Model
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