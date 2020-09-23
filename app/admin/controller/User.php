<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;

/**
 * 系统用户管理
 * Class User
 * @package app\admin\controller
 */
class User extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    public $table = 'SystemUser';

    /**
     * 系统用户管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '系统用户管理';
        $query = $this->_query($this->table);
        $query->equal('status')->dateBetween('login_at,create_at');
        $query->like('username,contact_phone#phone,contact_mail#mail');
        // 加载对应数据列表
        $this->type = input('type', 'all');
        if ($this->type === 'all') {
            $query->where(['is_deleted' => 0, 'status' => 1]);
        } elseif ($this->type = 'recycle') {
            $query->where(['is_deleted' => 0, 'status' => 0]);
        }
        // 列表排序并显示
        $query->order('sort desc,id desc')->page();
    }

    /**
     * 添加系统用户
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑系统用户
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 修改用户密码
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function pass()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->verify = false;
            $this->_form($this->table, 'pass');
        } else {
            $data = $this->_vali([
                'id.require'                  => '用户ID不能为空！',
                'password.require'            => '登录密码不能为空！',
                'repassword.require'          => '重复密码不能为空！',
                'repassword.confirm:password' => '两次输入的密码不一致！',
            ]);
            if (data_save($this->table, ['id' => $data['id'], 'password' => md5($data['password'])], 'id')) {
                $this->success('密码修改成功，请使用新密码登录！', '');
            } else {
                $this->error('密码修改失败，请稍候再试！');
            }
        }
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isPost()) {
            if (isset($data['id']) && $data['id'] > 0) {
                unset($data['username']);
            } else {
                // 检查登录账号是否出现重复
                if (empty($data['username'])) $this->error('登录账号不能为空！');
                $where = ['username' => $data['username'], 'is_deleted' => 0];
                if ($this->app->db->name($this->table)->where($where)->count() > 0) {
                    $this->error("账号{$data['username']}已经存在，请使用其它账号！");
                }
                // 新添加的用户密码与账号相同
                $data['password'] = md5($data['username']);
            }
            // 账号权限绑定处理
            $data['authorize'] = (isset($data['authorize']) && is_array($data['authorize'])) ? join(',', $data['authorize']) : '';
        } else {
            $data['authorize'] = explode(',', $data['authorize'] ?? '');
            $this->authorizes = $this->app->db->name('SystemAuth')->where(['status' => 1])->order('sort desc,id desc')->select()->toArray();
        }
    }

    /**
     * 修改用户状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_checkInput();
        $this->_applyFormToken();
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除系统用户
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_checkInput();
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

    /**
     * 检查输入变量
     */
    private function _checkInput()
    {
        if (in_array('10000', explode(',', input('id', '')))) {
            $this->error('系统超级账号禁止删除！');
        }
    }

}
