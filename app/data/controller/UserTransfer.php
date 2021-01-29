<?php

namespace app\data\controller;

use app\data\service\UserService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\service\AdminService;

/**
 * 用户提现管理
 * Class UserTransfer
 * @package app\data\controller
 */
class UserTransfer extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserTransfer';

    /**
     * 用户提现管理
     * @menu true
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '用户提现管理';
        $query = $this->_query($this->table)->order('id desc');
        // 用户条件搜索
        $db = $this->_query('DataUser')->like('phone,username|nickname#nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("uid in {$db->field('id')->buildSql()}");
        // 数据列表处理
        $query->equal('type,status')->dateBetween('create_at')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _page_filter(array &$data)
    {
        UserService::instance()->buildByUid($data);
    }

    /**
     * 提现审核打款
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function audit()
    {
        if ($this->request->isGet()) {
            $this->_form($this->table, 'audit', 'code');
        } else {
            $data = $this->_vali([
                'remark.default'      => '',
                'code.require'        => '打款单号不能为空！',
                'status.require'      => '交易审核操作类型！',
                'status.in:0,1,2,3,4' => '交易审核操作类型！',
            ]);
            $map = ['code' => $data['code']];
            $find = $this->app->db->name($this->table)->where($map)->find();
            if (empty($find)) $this->error('不允许操作审核！');
            // 提现状态(0已拒绝, 1待审核, 2已审核, 3打款中, 4已打款, 5已收款)
            if (in_array($data['status'], [0, 1, 2, 3])) {
                $data['last_at'] = date('Y-m-d H:i:s');
            } elseif ($data['status'] == 4) {
                $data['trade_no'] = CodeExtend::uniqidDate(14);
                $data['trade_time'] = date('Y-m-d H:i:s');
                $data['change_time'] = date('Y-m-d H:i:s');
                $data['change_desc'] = ($data['remark'] ?: '线下打款成功') . ' By ' . AdminService::instance()->getUserName();
            }
            if ($this->app->db->name($this->table)->strict(false)->where($map)->update($data) !== false) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败！');
            }
        }
    }

    /**
     * 后台打款服务
     * @auth true
     */
    public function sync()
    {
        $this->_queue('提现到余额定时处理', 'xdata:UserTransfer', 0, [], 0, 50);
    }

}