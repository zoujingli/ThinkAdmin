<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\UserService;
use think\admin\extend\CodeExtend;

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
    private $table = 'DataUserBalanceTransfer';

    /**
     * 获取用户转账记录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get()
    {
        $query = $this->_query($this->table);
        $query->where(['uid|from' => $this->uuid, 'deleted' => 0]);
        $result = $query->order('id desc')->page(true, false, false, 15);
        if (count($result['list']) > 0) {
            UserService::instance()->buildByUid($result['list'], 'uid', 'selfer');
            UserService::instance()->buildByUid($result['list'], 'from', 'fromer');
        }
        $this->success('获取数据成功', $result);
    }

    /**
     * 创建余额转账申请
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $data = $this->_vali([
            'from.value'     => $this->uuid,
            'code.value'     => CodeExtend::uniqidDate(18, 'T'),
            'uid.require'    => '目标用户不能为空！',
            'name.default'   => '用户余额转账',
            'amount.require' => '转账金额不能为空！',
        ]);
        if ($data['uid'] == $this->uuid) {
            $this->error('不能给自己转账！');
        }
        // 检测目标用户状态
        $map = ['id' => $data['uid'], 'deleted' => 0];
        $user = $this->app->db->name('DataUser')->where($map)->find();
        if (empty($user)) $this->error('目标用户不存在！');
        // 检测余额否有足够
        [$total, $count] = UserService::instance()->balance($this->uuid);
        if ($data['amount'] > $total - $count) $this->error('可转账余额不足！');
        // 写入余额转账记录
        if ($this->app->db->name($this->table)->insert($data) !== false) {
            UserService::instance()->balance($data['uid']);
            UserService::instance()->balance($data['from']);
            $this->success('余额转账成功！');
        } else {
            $this->error('余额转账失败！');
        }
    }
}