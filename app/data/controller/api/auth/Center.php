<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\UserService;

/**
 * 会员资料管理
 * Class Center
 * @package app\data\controller\api\auth
 */
class Center extends Auth
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'DataMember';

    /**
     * 更新会员资料
     * @throws \think\db\exception\DbException
     */
    public function set()
    {
        $data = $this->_vali([
            'headimg.default'       => '',
            'username.default'      => '',
            'base_age.default'      => '',
            'base_sex.default'      => '',
            'base_height.default'   => '',
            'base_weight.default'   => '',
            'base_birthday.default' => '',
        ]);
        foreach ($data as $key => $vo) if ($vo === '') unset($data[$key]);
        if (empty($data)) $this->error('没有需要修改的数据！');
        if ($this->app->db->name($this->table)->where(['id' => $this->mid])->update($data) !== false) {
            $this->success('更新会员资料成功！', $this->getMember());
        } else {
            $this->error('更新会员资料失败！');
        }
    }

    /**
     * 获取会员资料
     */
    public function get()
    {
        $this->success('获取会员资料', $this->getMember());
    }

    /**
     * 获取会员数据统计
     */
    public function total()
    {
        $this->success('获取会员数据统计!', UserService::instance()->total($this->mid));
    }

    /**
     * 绑定会员邀请人
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function bindFrom()
    {
        $data = $this->_vali(['from.require' => '邀请人不能为空']);
        if ($data['from'] == $this->mid) {
            $this->error('邀请人不能是自己哦', UserService::instance()->total($this->mid));
        }
        $from = $this->app->db->name($this->table)->where(['id' => $data['from']])->find();
        if (empty($from)) $this->error('邀请人状态异常', UserService::instance()->get($this->mid));
        if ($this->member['from'] > 0) $this->error('您已经绑定了邀请人', UserService::instance()->total($this->mid));
        if ($this->app->db->name($this->table)->where(['id' => $this->mid])->update($data) !== false) {
            $this->success('绑定邀请人成功！', UserService::instance()->total($this->mid));
        } else {
            $this->error('绑定邀请人失败！', UserService::instance()->total($this->mid));
        }
    }

    /**
     * 获取我邀请的朋友
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getFrom()
    {
        $query = $this->_query($this->table);
        $query->where(['from' => $this->mid])->field('id,from,username,nickname,headimg,create_at');
        $this->success('获取我邀请的朋友', $query->order('id desc')->page(true, false, false, 15));
    }
}