<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\controller\UserTransfer;
use app\data\service\UserTransferService;
use think\admin\extend\CodeExtend;

/**
 * 用户提现接口
 * Class Transfer
 * @package app\data\controller\api\auth
 */
class Transfer extends Auth
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserTransfer';

    public function add()
    {
        $data = $this->_vali([
            'code.value'     => CodeExtend::uniqidDate(20, 'T'),
            'type.require'   => '提现方式不能为空！',
            'amount.require' => '提现金额不能为空！',
        ]);

        $chargeRate = floatval(UserTransferService::instance()->config('transfer_charge'));
        $chargeAmount = $chargeRate * $data['amount'];
    }

    public function get()
    {
    }

    /**
     * 获取用户提现配置
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config()
    {
        $data = UserTransferService::instance()->config();
        $this->success('获取用户提现配置', $data);
    }
}