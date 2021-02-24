<?php

namespace app\data\controller;

use app\data\service\UserService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\service\AdminService;

/**
 * 余额充值记录
 * Class UserBalance
 * @package app\data\controller
 */
class UserBalance extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserBalance';

    /**
     * 余额充值管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '余额充值记录';
        $query = $this->_query($this->table);
        // 用户搜索查询
        $db = $this->_query('DataUser')->like('phone#user_phone,nickname#user_nickname')->db();
        if ($db->getOptions('where')) $query->whereRaw("uid in {$db->field('id')->buildSql()}");
        // 数据查询分页
        $query->where(['deleted' => 0])->like('code,name')->dateBetween('create_at')->order('id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        UserService::instance()->buildByUid($data);
        $uids = array_unique(array_column($data, 'create_by'));
        $users = $this->app->db->name('SystemUser')->whereIn('id', $uids)->column('username', 'id');
        foreach ($data as &$vo) $vo['create_byname'] = $users[$vo['create_by']] ?? $vo['create_by'];
    }

    /**
     * 添加余额充值
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $data = $this->_vali(['uid.require' => '用户UID不能为空！']);
        $this->user = $this->app->db->name('DataUser')->where(['id' => $data['uid']])->find();
        if (empty($this->user)) $this->error('待充值的用户不存在！');
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        if (empty($data['code'])) {
            $data['code'] = CodeExtend::uniqidDate('16', 'B');
        }
        if ($this->request->isPost()) {
            $data['create_by'] = AdminService::instance()->getUserId();
            if (empty(floatval($data['amount']))) $this->error('充值金额不能为零');
        }
    }

    /**
     * 表单结果处理
     * @param bool $state
     * @param array $data
     * @throws \think\db\exception\DbException
     */
    protected function _form_result(bool $state, array $data)
    {
        if ($state && isset($data['uid'])) {
            UserService::instance()->balance($data['uid']);
        }
    }

    /**
     * 删除充值记录
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

    /**
     * 删除结果处理
     * @param bool $state
     * @throws \think\db\exception\DbException
     */
    protected function _delete_result(bool $state)
    {
        if ($state) {
            $ids = str2arr(input('id', ''));
            $query = $this->app->db->name($this->table);
            foreach ($query->whereIn('id', $ids)->cursor() as $vo) {
                UserService::instance()->balance($vo['uid']);
            }
        }
    }
}