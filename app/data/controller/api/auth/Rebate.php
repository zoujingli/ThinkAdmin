<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\UserRebateService;
use think\admin\extend\CodeExtend;

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
        $query = $this->_query($this->table)->where(['uid' => $this->uuid]);
        $query->like('create_at#date')->order('id desc')->page(true, false, false, 15);
    }
}