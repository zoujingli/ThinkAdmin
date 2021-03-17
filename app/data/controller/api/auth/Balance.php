<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;

/**
 * 用户余额转账
 * Class Balance
 * @package app\data\controller\api\auth
 */
class Balance extends Auth
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserBalance';

    /**
     * 获取用户余额记录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get()
    {
        $query = $this->_query($this->table);
        $query->withoutField('deleted,create_by')->where(['uid' => $this->uuid, 'deleted' => 0]);
        $result = $query->like('create_at#date')->order('id desc')->page(true, false, false, 10);
        $this->success('获取数据成功', $result);
    }
}