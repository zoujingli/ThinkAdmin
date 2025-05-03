<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemAuth;
use think\admin\model\SystemBase;
use think\admin\model\SystemUser;
use think\admin\service\AdminService;

/**
 * 系统用户管理
 * @class User
 * @package app\admin\controller
 */
class User extends Controller
{
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
        $this->type = $this->get['type'] ?? 'index';
        SystemUser::mQuery()->layTable(function () {
            $this->title = '系统用户管理';
            $this->bases = SystemBase::items('身份权限');
        }, function (QueryHelper $query) {

            // 加载对应数据列表
            $query->where(['is_deleted' => 0, 'status' => intval($this->type === 'index')]);

            // 关联用户身份资料
            /** @var \think\model\Relation|\think\db\Query $query */
            $query->with(['userinfo' => static function ($query) {
                $query->field('code,name,content');
            }]);

            // 数据列表搜索过滤
            $query->equal('status,usertype')->dateBetween('login_at,create_at');
            $query->like('username|nickname#username,contact_phone#phone,contact_mail#mail');
        });
    }

    /**
     * 添加系统用户
     * @auth true
     */
    public function add()
    {
        SystemUser::mForm('form');
    }

    /**
     * 编辑系统用户
     * @auth true
     */
    public function edit()
    {
        SystemUser::mForm('form');
    }

    /**
     * 修改用户密码
     * @auth true
     */
    public function pass()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->verify = false;
            SystemUser::mForm('pass');
        } else {
            $data = $this->_vali([
                'id.require'                  => '用户ID不能为空！',
                'password.require'            => '登录密码不能为空！',
                'repassword.require'          => '重复密码不能为空！',
                'repassword.confirm:password' => '两次输入的密码不一致！',
            ]);
            $user = SystemUser::mk()->findOrEmpty($data['id']);
            if ($user->isExists() && $user->save(['password' => md5($data['password'])])) {
                // 修改密码同步事件处理
                $this->app->event->trigger('PluginAdminChangePassword', [
                    'uuid' => $data['id'], 'pass' => $data['password']
                ]);
                sysoplog('系统用户管理', "修改用户[{$data['id']}]密码成功");
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
            // 检查资料是否完整
            empty($data['username']) && $this->error('登录账号不能为空！');
            if ($data['username'] !== AdminService::getSuperName()) {
                empty($data['authorize']) && $this->error('未配置权限！');
            }
            // 处理上传的权限格式
            $data['authorize'] = arr2str($data['authorize'] ?? []);
            if (empty($data['id'])) {
                // 检查账号是否重复
                $map = ['username' => $data['username'], 'is_deleted' => 0];
                if (SystemUser::mk()->where($map)->count() > 0) {
                    $this->error("账号已经存在，请使用其它账号！");
                }
                // 新添加的用户密码与账号相同
                $data['password'] = md5($data['username']);
            } else {
                unset($data['username']);
            }
        } else {
            // 权限绑定处理
            $data['authorize'] = str2arr($data['authorize'] ?? '');
            $this->auths = SystemAuth::items();
            $this->bases = SystemBase::items('身份权限');
            $this->super = AdminService::getSuperName();
        }
    }

    /**
     * 修改用户状态
     * @auth true
     */
    public function state()
    {
        $this->_checkInput();
        SystemUser::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除系统用户
     * @auth true
     */
    public function remove()
    {
        $this->_checkInput();
        SystemUser::mDelete();
    }

    /**
     * 检查输入变量
     */
    private function _checkInput()
    {
        if (in_array('10000', str2arr(input('id', '')))) {
            $this->error('系统超级账号禁止删除！');
        }
    }
}
