<?php

namespace app\data\model;

use think\admin\Model;

/**
 * 用户等级配置模型
 * Class BaseUserUpgrade
 * @package app\data\model
 */
class BaseUserUpgrade extends Model
{
    /**
     * 获取用户等级
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function items(): array
    {
        return static::mk()->where(['status' => 1])
            ->hidden(['id', 'utime', 'status', 'create_at'])
            ->order('number asc')->select()->toArray();
    }

    /**
     * 获取最大级别数
     * @return int
     */
    public static function maxNumber(): int
    {
        return static::mk()->max('number', 0) + 1;
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