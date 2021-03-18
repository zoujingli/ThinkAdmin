<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\RebateService;

/**
 * 用户返利管理
 * Class Rebate
 * @package app\data\controller\api\auth
 */
class Rebate extends Auth
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserRebate';

    /**
     * 获取用户返利记录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get()
    {
        $query = $this->_query($this->table)->where(['uid' => $this->uuid])->equal('type,status');
        $result = $query->like('create_at#date')->order('id desc')->page(true, false, false, 15);
        $this->success('获取用户返利', $result);
    }

    /**
     * 获取奖励配置
     */
    public function prize()
    {
        $this->success('获取奖励配置', RebateService::PRIZES);
    }
}