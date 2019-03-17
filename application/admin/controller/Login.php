<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use controller\BasicAdmin;
use service\LogService;
use service\NodeService;
use think\Db;
use think\facade\Validate;


/**
 * 系统登录控制器
 * class Login
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/10 13:59
 */
class Login extends BasicAdmin
{

    /**
     * 控制器基础方法
     */
    public function initialize()
    {
        if (session('user.id') && $this->request->action() !== 'out') {
            $this->redirect('@admin');
        }
    }

    /**
     * 用户登录
     * @return string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        if ($this->request->isGet()) {
            return $this->fetch('', ['title' => '用户登录']);
        }
        // 输入数据效验
        $validate = Validate::make([
            'username' => 'require|min:4',
            'password' => 'require|min:4',
        ], [
            'username.require' => '登录账号不能为空！',
            'username.min'     => '登录账号长度不能少于4位有效字符！',
            'password.require' => '登录密码不能为空！',
            'password.min'     => '登录密码长度不能少于4位有效字符！',
        ]);
        $data = [
            'username' => $this->request->post('username', ''),
            'password' => $this->request->post('password', ''),
        ];
        $validate->check($data) || $this->error($validate->getError());
        // 用户信息验证
        $user = Db::name('SystemUser')->where(['username' => $data['username'], 'is_deleted' => '0'])->find();
        empty($user) && $this->error('登录账号不存在，请重新输入!');
        empty($user['status']) && $this->error('账号已经被禁用，请联系管理员!');
        $user['password'] !== md5($data['password']) && $this->error('登录密码错误，请重新输入!');
        // 更新登录信息
        Db::name('SystemUser')->where(['id' => $user['id']])->update([
            'login_at'  => Db::raw('now()'),
            'login_num' => Db::raw('login_num+1'),
        ]);
        session('user', $user);
        !empty($user['authorize']) && NodeService::applyAuthNode();
        LogService::write('系统管理', '用户登录系统成功');
        $this->success('登录成功，正在进入系统...', '@admin');
    }

    /**
     * 退出登录
     */
    public function out()
    {
        session('user') && LogService::write('系统管理', '用户退出系统成功');
        !empty($_SESSION) && $_SESSION = [];
        [session_unset(), session_destroy()];
        $this->success('退出登录成功！', '@admin/login');
    }

}
