<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\service\AuthService;
use app\admin\service\MenuService;
use think\admin\Controller;
use think\admin\extend\DataExtend;

/**
 * 后台界面入口
 * Class Index
 * @package app\admin\controller
 */
class Index extends Controller
{

    /**
     * 显示后台首页
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '系统管理后台';
        AuthService::apply(true);
        $this->menus = MenuService::getTree();
        if (empty($this->menus) && !AuthService::isLogin()) {
            $this->redirect(url('@admin/login'));
        } else {
            $this->fetch();
        }
    }

    /**
     * 后台环境信息
     */
    public function main()
    {
        $this->think_ver = $this->app->version();
        $this->mysql_ver = $this->app->db->query('select version() as ver')[0]['ver'];
        $this->fetch();
    }

    /**
     * 修改用户资料
     * @param integer $id 会员ID
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function info($id = 0)
    {
        if (!AuthService::isLogin()) {
            $this->error('需要登录才能操作哦！');
        }
        $this->_applyFormToken();
        if (intval($this->app->session->get('user.id')) === intval($id)) {
            $this->_form('SystemUser', 'admin@user/form', 'id', [], ['id' => $id]);
        } else {
            $this->error('只能修改登录用户的资料！');
        }
    }

    /**
     * 修改当前用户密码
     * @param integer $id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function pass($id = 0)
    {
        if (!AuthService::isLogin()) {
            $this->error('需要登录才能操作哦！');
        }
        $this->_applyFormToken();
        if (intval($this->app->session->get('user.id')) !== intval($id)) {
            $this->error('只能修改当前用户的密码！');
        }
        if ($this->app->request->isGet()) {
            $this->verify = true;
            $this->_form('SystemUser', 'admin@user/pass', 'id', [], ['id' => $id]);
        } else {
            $data = [
                'password'    => $this->app->request->post('password'),
                'repassword'  => $this->app->request->post('repassword'),
                'oldpassword' => $this->app->request->post('oldpassword'),
            ];
            if (empty($data['password'])) $this->error('登录密码不能为空！');
            if (empty($data['oldpassword'])) $this->error('旧密码不能为空！');
            if ($data['repassword'] !== $data['password']) {
                $this->error('重复密码与登录密码不匹配，请重新输入！');
            }
            $user = $this->app->db->name('SystemUser')->where(['id' => $id])->find();
            if (md5($data['oldpassword']) !== $user['password']) {
                $this->error('旧密码验证失败，请重新输入！');
            }
            if (DataExtend::save('SystemUser', ['id' => $user['id'], 'password' => md5($data['password'])])) {
                $this->success('密码修改成功，下次请使用新密码登录！', '');
            } else {
                $this->error('密码修改失败，请稍候再试！');
            }
        }
    }

}