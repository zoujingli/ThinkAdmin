<?php

namespace app\data\service;

use think\admin\extend\CodeExtend;
use think\admin\Service;

/**
 * 会员数据服务
 * Class MemberService
 * @package app\store\service
 */
class MemberService extends Service
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'DataMember';

    /**
     * 获取商品会员资料
     * @param string $openid
     * @param array $data
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get($openid, $data = [])
    {
        $map = ['id|openid' => $openid, 'deleted' => 0];
        $query = $this->app->db->name($this->table)->where($map);
        $member = $query->withoutField('status,deleted')->find();
        if (empty($member)) throw new \think\Exception('会员查询失败');
        return array_merge($member, $data);
    }

    /**
     * 刷新会员授权token
     * @param string $openid
     * @param array $data
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function token($openid, $data = [])
    {
        $map = ['id|openid' => $openid, 'deleted' => 0];
        $this->app->db->name($this->table)->where($map)->update([
            'token' => CodeExtend::random(20, 3, 't'),
        ]);
        return $this->get($openid, $data);
    }

    /**
     * 获取会员数据统计
     * @param integer $mid
     * @return array
     */
    public function total($mid)
    {
        return [
            'myinvited' => $this->app->db->name($this->table)->where(['from' => $mid])->count(),
        ];
    }

}