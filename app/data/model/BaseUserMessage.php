<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 用户通知消息模型
 * Class BaseUserMessage
 * @package app\data\model
 */
class BaseUserMessage extends Model
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