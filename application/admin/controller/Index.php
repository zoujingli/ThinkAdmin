<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\admin\controller;

use library\Controller;
use library\tools\Data;
use think\Console;
use think\Db;

/**
 * 后台入口管理
 * Class Index
 * @package app\admin\controller
 */
class Index extends Controller
{

    /**
     * 显示后台首页
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $this->title = '系统管理后台';
        $this->menus = \app\admin\service\Auth::getAuthMenu();
        if (empty($this->menus) && !session('user.id')) {
            $this->redirect('@admin/login');
        } else {
            $this->fetch();
        }
    }

    /**
     * 后台环境信息
     * @return mixed
     */
    public function main()
    {
        $this->title = '后台首页';
        $this->think_ver = \think\App::VERSION;
        $this->mysql_ver = Db::query('select version() as ver')[0]['ver'];
        $this->fetch();
    }

    /**
     * 清理系统运行缓存
     */
    public function clearRuntime()
    {
        if (!\app\admin\service\Auth::isLogin()) {
            $this->error('需要登录才能操作哦！');
        }
        $this->list = [
            [
                'title'   => 'Clean up running cached files',
                'message' => nl2br(Console::call('clear')->fetch()),
            ], [
                'title'   => 'Clean up invalid session files',
                'message' => nl2br(Console::call('xclean:session')->fetch()),
            ],
        ];
        $this->fetch('admin@index/command');
    }

    /**
     * 压缩发布系统
     */
    public function buildOptimize()
    {
        if (!\app\admin\service\Auth::isLogin()) {
            $this->error('需要登录才能操作哦！');
        }
        $this->list = [
            [
                'title'   => 'Build route cache',
                'message' => nl2br(Console::call('optimize:route')->fetch()),
            ], [
                'title'   => 'Build database schema cache',
                'message' => nl2br(Console::call('optimize:schema')->fetch()),
            ], [
                'title'   => 'Optimizes PSR0 and PSR4 packages',
                'message' => nl2br(Console::call('optimize:autoload')->fetch()),
            ], [
                'title'   => 'Build config and common file cache',
                'message' => nl2br(Console::call('optimize:config')->fetch()),
            ],
        ];
        $this->fetch('admin@index/command');
    }

    /**
     * 修改密码
     * @param integer $id
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function pass($id)
    {
        $this->applyCsrfToken();
        if (intval($id) !== intval(session('user.id'))) {
            $this->error('只能修改当前用户的密码！');
        }
        if ($this->request->isGet()) {
            $this->verify = true;
            $this->_form('SystemUser', 'admin@user/pass', 'id', [], ['id' => $id]);
        } else {
            $data = $this->_input([
                'password'    => $this->request->post('password'),
                'repassword'  => $this->request->post('repassword'),
                'oldpassword' => $this->request->post('oldpassword'),
            ], [
                'oldpassword' => 'require',
                'password'    => 'require|min:4',
                'repassword'  => 'require|confirm:password',
            ], [
                'oldpassword.require' => '旧密码不能为空！',
                'password.require'    => '登录密码不能为空！',
                'password.min'        => '登录密码长度不能少于4位有效字符！',
                'repassword.require'  => '重复密码不能为空！',
                'repassword.confirm'  => '重复密码与登录密码不匹配，请重新输入！',
            ]);
            $user = Db::name('SystemUser')->where(['id' => $id])->find();
            if (md5($data['oldpassword']) !== $user['password']) {
                $this->error('旧密码验证失败，请重新输入！');
            }
            $result = \app\admin\service\Auth::checkPassword($data['password']);
            if (empty($result['code'])) $this->error($result['msg']);
            if (Data::save('SystemUser', ['id' => $user['id'], 'password' => md5($data['password'])])) {
                $this->success('密码修改成功，下次请使用新密码登录！', '');
            } else {
                $this->error('密码修改失败，请稍候再试！');
            }
        }
    }

    /**
     * 修改用户资料
     * @param integer $id 会员ID
     */
    public function info($id = 0)
    {
        $this->applyCsrfToken();
        if (intval($id) === intval(session('user.id'))) {
            $this->_form('SystemUser', 'user/form', 'id', [], ['id' => $id]);
        } else {
            $this->error('只能修改登录用户的资料！');
        }
    }

}