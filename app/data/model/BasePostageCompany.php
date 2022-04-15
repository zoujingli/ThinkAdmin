<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 快递公司模型
 * Class BasePostageCompany
 * @package app\data\model
 */
class BasePostageCompany extends Model
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