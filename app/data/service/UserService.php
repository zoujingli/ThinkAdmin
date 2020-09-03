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
     * @param string $token 接口认证
     * @param array $data 额外数据
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get(string $token, array $data = []): array
    {
        $map = ['token' => $token, 'deleted' => 0];
        $query = $this->app->db->name($this->table)->where($map);
        $member = $query->withoutField('status,deleted')->find();
        if (empty($member)) {
            throw new \think\Exception('登录授权失败');
        }
        if ($member['tokenv'] !== $this->buildTokenVerify()) {
            throw new \think\Exception('请重新登录授权');
        }
        return array_merge($member, $data);
    }

    /**
     * 刷新会员授权 TOKEN
     * @param int $mid 会员MID
     * @param array $data 额外数据
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function token(int $mid, array $data = []): array
    {
        // 生成新的接口令牌
        do $update = ['token' => md5(uniqid("{$mid}#", true) . rand(100, 999))];
        while ($this->app->db->name($this->table)->where($update)->count() > 0);
        // 更新账号授权令牌
        $this->app->db->name($this->table)->where(['id' => $mid, 'deleted' => 0])->update([
            'token' => $update['token'], 'tokenv' => $this->buildTokenVerify(),
        ]);
        // 获取新的会员数据
        return $this->get($update['token'], $data);
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
     * 获取认证信息编码
     * @return string
     */
    private function buildTokenVerify(): string
    {
        return md5($this->app->request->server('HTTP_USER_AGENT', '-'));
    }

}