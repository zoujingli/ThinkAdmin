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
use think\admin\extend\CodeExtend;
use think\admin\service\AdminService;
use think\admin\service\CaptchaService;
use think\admin\service\SystemService;

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
            if (AdminService::instance()->isLogin()) {
                $this->redirect(sysuri('admin/index/index'));
            } else {
                $this->title = '系统登录';
                $this->captchaType = 'LoginCaptcha';
                $this->captchaToken = CodeExtend::uniqidDate(18);
                $this->devmode = SystemService::instance()->checkRunMode('dev');
                if (!$this->app->session->get('login_input_session_error')) {
                    $this->app->session->set($this->captchaType, $this->captchaToken);
                }
                $this->fetch();
            }
        } else {
            $data = $this->_vali([
                'username.require' => '登录账号不能为空!',
                'username.min:4'   => '登录账号不能少于4位字符!',
                'password.require' => '登录密码不能为空!',
                'password.min:4'   => '登录密码不能少于4位字符!',
                'verify.require'   => '图形验证码不能为空!',
                'uniqid.require'   => '图形验证标识不能为空!',
            ]);
            if (!CaptchaService::instance()->check($data['verify'], $data['uniqid'])) {
                $this->error('图形验证码验证失败，请重新输入!');
            }
            /*! 用户信息验证 */
            $map = ['username' => $data['username'], 'is_deleted' => '0'];
            $user = $this->app->db->name('SystemUser')->where($map)->order('id desc')->find();
            if (empty($user)) {
                $this->app->session->set("login_input_session_error", true);
                $this->error('登录账号或密码错误，请重新输入!');
            }
            if (md5("{$user['password']}{$data['uniqid']}") !== $data['password']) {
                $this->app->session->set("login_input_session_error", true);
                $this->error('登录账号或密码错误，请重新输入!');
            }
            if (empty($user['status'])) {
                $this->error('账号已经被禁用，请联系管理员!');
            }
            $this->app->session->set('user', $user);
            $this->app->session->delete("login_input_session_error");
            $this->app->db->name('SystemUser')->where(['id' => $user['id']])->update([
                'login_ip'  => $this->app->request->ip(),
                'login_at'  => $this->app->db->raw('now()'),
                'login_num' => $this->app->db->raw('login_num+1'),
            ]);
            sysoplog('用户登录', '登录系统后台成功');
            $GLOBALS['oplogs'] = [];
            $this->success('登录成功', sysuri('admin/index/index'));
        }
    }

    /**
     * 生成验证码
     */
    public function captcha()
    {
        $input = $this->_vali([
            'type.require'  => '验证码类型不能为空!',
            'token.require' => '验证码标识不能为空!',
        ]);
        $image = CaptchaService::instance()->initialize();
        $captcha = ['image' => $image->getData(), 'uniqid' => $image->getUniqid()];
        if ($this->app->session->get($input['type']) === $input['token']) {
            $captcha['code'] = $image->getCode();
            $this->app->session->delete($input['type']);
        }
        $this->success('生成验证码成功', $captcha);
    }

    /**
     * 退出登录
     */
    public function out()
    {
        $this->app->session->clear();
        $this->app->session->destroy();
        $this->success('退出登录成功!', sysuri('admin/login/index'));
    }

}
