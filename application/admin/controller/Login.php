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
use think\Db;

/**
 * 用户登录管理
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{

    /**
     * 后台登录入口
     */
    public function index()
    {
        $this->title = '系统登录';
    }

    /**
     * 后台登录页面显示
     */
    protected function _index_get()
    {
        if (\app\admin\service\Auth::isLogin()) {
            $this->redirect('@admin');
        } else {
            $this->loginskey = session('loginskey');
            if (empty($this->loginskey)) {
                $this->loginskey = uniqid();
                session('loginskey', $this->loginskey);
            }
            $this->fetch();
        }
    }

    /**
     * 后台登录数据处理
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _index_post()
    {
        $data = $this->_input([
            'username' => $this->request->post('username'),
            'password' => $this->request->post('password'),
        ], [
            'username' => 'require|min:4',
            'password' => 'require|min:4',
        ], [
            'username.require' => '登录账号不能为空！',
            'password.require' => '登录密码不能为空！',
            'username.min'     => '登录账号长度不能少于4位有效字符！',
            'password.min'     => '登录密码长度不能少于4位有效字符！',
        ]);
        // 用户信息验证
        $map = ['is_deleted' => '0', 'username' => $data['username']];
        $user = Db::name('SystemUser')->where($map)->order('id desc')->find();
        if (empty($user)) $this->error('登录账号或密码错误，请重新输入!');
        if (empty($user['status'])) $this->error('账号已经被禁用，请联系管理员!');
        // 账号锁定消息
        $cache = cache("user_login_{$user['username']}");
        if (is_array($cache) && !empty($cache['number']) && !empty($cache['time'])) {
            if ($cache['number'] >= 10 && ($diff = $cache['time'] + 3600 - time()) > 0) {
                list($m, $s, $info) = [floor($diff / 60), floor($diff % 60), ''];
                if ($m > 0) $info = "{$m} 分";
                $this->error("<strong class='color-red'>抱歉，该账号已经被锁定！</strong><p class='nowrap'>连续 10 次登录错误，请 {$info} {$s} 秒后再登录！</p>");
            }
        }
        if (md5($user['password'] . session('loginskey')) !== $data['password']) {
            if (empty($cache) || empty($cache['time']) || empty($cache['number']) || $cache['time'] + 3600 < time()) {
                $cache = ['time' => time(), 'number' => 1, 'geoip' => $this->request->ip()];
            } elseif ($cache['number'] + 1 <= 10) {
                $cache = ['time' => time(), 'number' => $cache['number'] + 1, 'geoip' => $this->request->ip()];
            }
            cache("user_login_{$user['username']}", $cache);
            if (($diff = 10 - $cache['number']) > 0) {
                $this->error("<strong class='color-red'>登录账号或密码错误！</strong><p class='nowrap'>还有 {$diff} 次尝试机会，将锁定一小时内禁止登录！</p>");
            } else {
                _syslog('系统管理', "账号{$user['username']}连续10次登录密码错误，请注意账号安全！");
                $this->error("<strong class='color-red'>登录账号或密码错误！</strong><p class='nowrap'>尝试次数达到上限，锁定一小时内禁止登录！</p>");
            }
        }
        // 登录成功并更新账号
        cache("user_login_{$user['username']}", null);
        Db::name('SystemUser')->where(['id' => $user['id']])->update([
            'login_at' => Db::raw('now()'), 'login_ip' => $this->request->ip(), 'login_num' => Db::raw('login_num+1'),
        ]);
        session('user', $user);
        session('loginskey', null);
        _syslog('系统管理', '用户登录系统成功');
        empty($user['authorize']) || \app\admin\service\Auth::applyNode();
        $this->success('登录成功，正在进入系统...', url('@admin'));
    }

    /**
     * 退出登录
     */
    public function out()
    {
        \think\facade\Session::clear();
        \think\facade\Session::destroy();
        $this->success('退出登录成功！', url('@admin/login'));
    }

}