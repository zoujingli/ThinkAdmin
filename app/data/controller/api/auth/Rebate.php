<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\UserUpgradeService;
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

    /**
     * 提交用户提现审核
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function addUsed()
    {
        if (!empty($this->user['status'])) {
            $this->error('账户异常，请联系客服');
        }
        $data = $this->_vali([
            'amount.require' => '提现金额不能为空',
            'remark.default' => '用户主动提交审核',
        ]);
        $params = sysdata('TransferRule') ?: [];
        if (empty($params['transfer_state'])) $this->error('提现功能已经关闭');
        [$total, $count] = UserUpgradeService::instance()->syncRebate($this->uuid);
        if ($total - $count - $data['amount'] < 0) $this->error('可提现金额不足');
        if ($data['amount'] < $params['transfer_min']) $this->error("提现不能少于{$params['transfer_min']}元");
        if ($data['amount'] > $params['transfer_max']) $this->error("提现不能大于{$params['transfer_max']}元");
        $result = $this->app->db->name('DataUserTransfer')->insert([
            'uid'    => $this->uuid,
            'code'   => CodeExtend::uniqidDate(20, 'T'),
            'openid' => $this->user['openid1'],
            'status' => $params['transfer_audit'] > 0 ? 2 : 1,
            'amount' => $data['amount'],
            'remark' => $data['remark'],
        ]);
        if ($result !== false) {
            UserUpgradeService::instance()->syncRebate($this->uuid);
            $this->success('提交申请成功');
        } else {
            $this->error('提交申请失败');
        }
    }

    /**
     * 获取用户提现记录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUsed()
    {
        $date = input('date', date('Y-m-'));
        $map = [['mid', '=', $this->mid], ['create_at', 'like', "{$date}%"]];
        $query = $this->_query('DataUserTransfer')->in('status')->order('id desc');
        $this->success('获取提现记录', $query->where($map)->page(true, false, false, 15));
    }
}