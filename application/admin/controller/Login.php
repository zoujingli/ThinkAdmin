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
    public function _initialize()
    {
        if (session('user') && $this->request->action() !== 'out') {
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
        $username = $this->request->post('username', '', 'trim');
        $password = $this->request->post('password', '', 'trim');
        strlen($username) < 4 && $this->error('登录账号长度不能少于4位有效字符!');
        strlen($password) < 4 && $this->error('登录密码长度不能少于4位有效字符!');
        // 用户信息验证
        $user = Db::name('SystemUser')->where('username', $username)->find();
        empty($user) && $this->error('登录账号不存在，请重新输入!');
        ($user['password'] !== md5($password)) && $this->error('登录密码与账号不匹配，请重新输入!');
        empty($user['status']) && $this->error('账号已经被禁用，请联系管理!');
        // 更新登录信息
        $data = ['login_at' => date('Y-m-d H:i:s'), 'login_num' => $user['login_num'] + 1];
        Db::name('SystemUser')->where(['id' => $user['id']])->update($data);
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
        if (session('user')) {
            LogService::write('系统管理', '用户退出系统成功');
        }
        session('user', null);
        session_destroy();
        $this->success('退出登录成功！', '@admin/login');
    }

}
