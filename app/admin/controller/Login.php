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
use think\admin\Controller;
use think\admin\extend\CaptchaExtend;

/**
 * 用户登录管理
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    /**
     * 后台登录入口
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        if ($this->app->request->isGet()) {
            if (AuthService::isLogin()) {
                $this->redirect(url('@admin')->suffix(false)->build());
            } else {
                $this->title = '系统登录';
                $this->domain = $this->app->request->host(true);
                $this->devmode = in_array($this->domain, ['127.0.0.1', 'localhost']);
                $this->devmode = $this->devmode ?: is_numeric(stripos($this->domain, 'thinkadmin.top'));
                $this->captcha = CaptchaExtend::instance();
                $this->fetch();
            }
        } elseif ($this->app->request->isPost()) {
            $data = ['username' => input('username'), 'password' => input('password')];
            if (empty($data['username'])) $this->error('登录账号不能为空!');
            if (empty($data['password'])) $this->error('登录密码不能为空!');
            if (!CaptchaExtend::check(input('verify'), input('uniqid'))) {
                $this->error('图形验证码验证失败，请重新输入!');
            }
            // 用户信息验证
            $map = ['username' => $data['username'], 'is_deleted' => '0'];
            $user = $this->app->db->name('SystemUser')->where($map)->order('id desc')->find();
            if (empty($user)) {
                $this->error('登录账号或密码错误，请重新输入!');
            }
            if (md5("{$user['password']}{$user['username']}") !== $data['password']) {
                $this->error('登录账号或密码错误，请重新输入!');
            }
            if (empty($user['status'])) {
                $this->error('账号已经被禁用，请联系管理员!');
            }
            $this->app->db->name('SystemUser')->where(['id' => $user['id']])->update([
                'login_ip'  => $this->app->request->ip(),
                'login_at'  => $this->app->db->raw('now()'),
                'login_num' => $this->app->db->raw('login_num+1'),
            ]);
            $this->app->session->set('user', $user);
            sysoplog('用户登录', "用户登录系统后台成功");
            $this->success('登录成功', url('@admin')->build());
        }
    }

    /**
     * 生成验证码
     */
    public function captcha()
    {
        $image = CaptchaExtend::instance();
        $this->success('生成验证码成功', [
            'image'  => $image->getData(),
            'uniqid' => $image->getUniqid(),
        ]);
    }

    /**
     * 退出登录
     */
    public function out()
    {
        $this->app->session->clear();
        $this->app->session->destroy();
        $this->success('退出登录成功!', url('@admin/login')->build());
    }

}