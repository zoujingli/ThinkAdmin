<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 新闻内容模型
 * Class DataNewsItem
 * @package app\data\model
 */
class DataNewsItem extends Model
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