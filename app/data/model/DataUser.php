<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 用户数据模型
 * Class DataUser
 * @package app\data\model
 */
class DataUser extends Model
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