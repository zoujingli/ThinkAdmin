<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 会员数据接口服务
 * Class UserService
 * @package app\store\service
 */
class UserService extends Service
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'DataMember';

    /**
     * 获取会员资料
     * @param array $map 查询条件
     * @param bool $force 强制令牌
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get(array $map, bool $force = false): array
    {
        $member = $this->save($map, [], $force);
        if (empty($member)) throw new \think\Exception('登录授权失败');
        // if ($member['tokenv'] !== $this->buildTokenVerify()) {
        //     throw new \think\Exception('请重新登录授权');
        // }
        return $member;
    }

    /**
     * 更新会员用户参数
     * @param array $map 查询条件
     * @param array $data 更新数据
     * @param boolean $force 强刷令牌
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function save(array $map, array $data = [], bool $force = false): array
    {
        $user = $this->app->db->name($this->table)->where($map)->where(['deleted' => 0])->find() ?: [];
        unset($data['id'], $data['token'], $data['tokenv'], $data['status'], $data['deleted'], $data['create_at']);
        if ($force) $data = array_merge($data, $this->_buildUserToken());
        if (empty($data)) {
            unset($user['deleted'], $user['password']);
            return $user;
        } elseif (empty($user['id'])) {
            $user['id'] = $this->app->db->name($this->table)->strict(false)->insertGetId($data);
        } else {
            $this->app->db->name($this->table)->strict(false)->where(['id' => $user['id']])->update($data);
        }
        $map = ['id' => $user['id'], 'deleted' => 0];
        $query = $this->app->db->name($this->table)->where($map);
        return $query->withoutField('deleted,password')->find() ?: [];
    }

    /**
     * 获取会员数据统计
     * @param int $mid 会员MID
     * @return array
     */
    public function total(int $mid): array
    {
        $query = $this->app->db->name($this->table);
        return ['my_invite' => $query->where(['from' => $mid])->count()];
    }

    /**
     * 生成新的用户令牌
     * @return array
     */
    private function _buildUserToken(): array
    {
        do $map = ['token' => md5(uniqid('', true) . rand(100, 999))];
        while ($this->app->db->name($this->table)->where($map)->count() > 0);
        return ['token' => $map['token'], 'tokenv' => $this->_buildTokenVerify()];
    }

    /**
     * 获取令牌的认证值
     * @return string
     */
    private function _buildTokenVerify(): string
    {
        return md5($this->app->request->server('HTTP_USER_AGENT', '-'));
    }

}