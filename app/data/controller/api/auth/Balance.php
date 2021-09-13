<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\model\DataUserBalance;

/**
 * 用户余额转账
 * Class Balance
 * @package app\data\controller\api\auth
 */
class Balance extends Auth
{
    /**
     * 获取用户余额记录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get()
    {
        $query = DataUserBalance::mQuery()->withoutField('deleted,create_by');
        $query->where(['uuid' => $this->uuid, 'deleted' => 0])->like('create_at#date');
        $this->success('获取数据成功', $query->order('id desc')->page(true, false, false, 10));
    }
}