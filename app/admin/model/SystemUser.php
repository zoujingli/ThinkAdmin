<?php

namespace app\admin\model;

use think\db\Query;
use think\Model;

/**
 * 系统用户数据模型
 * Class SystemUser
 * @package app\admin\model
 */
class SystemUser extends Model
{
    /**
     * 获取用户数据
     * @param array $map 数据查询规则
     * @param array $data 用户数据集合
     * @param string $field 原外连字段
     * @param string $target 关联目标字段
     * @param string $fields 关联数据字段
     * @return array
     */
    public function items(array $map, array &$data = [], string $field = 'uuid', string $target = 'user_info', string $fields = 'username,nickname,headimg,status,is_deleted'): array
    {
        $query = $this->where($map)->order('sort desc,id desc');
        if (count($data) > 0) {
            $users = $query->whereIn('id', array_unique(array_column($data, $field)))->column($fields, 'id');
            foreach ($data as &$vo) $vo[$target] = $users[$vo[$field]] ?? [];
            return $users;
        } else {
            return $query->column($fields, 'id');
        }
    }

    /**
     * 通过身份类型获取
     * @param string $type 身份类型
     * @param string $fields 数据字段
     * @return array
     */
    public function itemsByType(string $type, string $fields = 'username,nickname,headimg,status,is_deleted'): array
    {
        $rids = (new SystemAuth)->where(['status' => 1, 'utype' => $type])->column('id');
        return empty($rids) ? [] : $this->where(function (Query $query) use ($rids) {
            foreach ($rids as $rid) $query->whereOr('authorize', 'like', "%,{$rid},%");
        })->where(['status' => 1, 'is_deleted' => 0])->column($fields, 'id');
    }

    /**
     * 获取用户身份数据
     * @param mixed $uuid
     * @return array
     */
    public function rolesByUuid($uuid): array
    {
        $types = (new SystemBase)->items('身份权限');
        if (empty($types)) return [];
        $rrids = str2arr($this->where(['id' => $uuid])->value('authorize') ?: '');
        if (empty($rrids)) return [];
        $utypes = (new SystemAuth)->where(['status' => 1])->whereIn('id', $rrids)->column('utype');
        if (empty($utypes)) return [];
        foreach ($types as $key => $type) if (!in_array($type, $utypes)) unset($types[$key]);
        return array_values($types);
    }

    /**
     * 格式化登录时间
     * @param string $value
     * @return string
     */
    public function getLoginAtAttr(string $value): string
    {
        return format_datetime($value);
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