<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\controller\api;

use app\data\model\DataUser;
use app\data\service\MessageService;
use app\data\service\UserAdminService;
use think\admin\Controller;

/**
 * 用户登录注册接口
 * Class Login
 * @package app\data\controller\api
 */
class Login extends Controller
{
    /**
     * 接口认证类型
     * @var string
     */
    private $type;

    /**
     * 控制器初始化
     */
    protected function initialize()
    {
        // 接收接口类型
        $this->type = $this->request->request('api');
        $this->type = $this->type ?: $this->request->header('api-name');
        $this->type = $this->type ?: $this->request->header('api-type');
        $this->type = $this->type ?: UserAdminService::API_TYPE_WAP;
        if (empty(UserAdminService::TYPES[$this->type])) {
            $this->error("接口支付[{$this->type}]未定义规则！");
        }
    }

    /**
     * 用户登录接口
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function in()
    {
        $data = $this->_vali([
            'phone.mobile'     => '手机号码格式错误！',
            'phone.require'    => '手机号码不能为空！',
            'password.require' => '登录密码不能为空！',
        ]);
        $map = ['deleted' => 0, 'phone' => $data['phone']];
        $user = DataUser::mk()->where($map)->findOrEmpty();
        if ($user->isEmpty()) $this->error('该手机号还没有注册哦！');
        if (empty($user['status'])) $this->error('该用户账号状态异常！');
        if (md5($data['password']) === $user['password']) {
            $this->success('手机登录成功！', UserAdminService::set($map, [], $this->type, true));
        } else {
            $this->error('账号登录失败，请稍候再试！');
        }
    }

    /**
     * 用户统一注册入口
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DbException
     */
    public function register()
    {
        $data = $this->_vali([
            'region_province.default' => '',
            'region_city.default'     => '',
            'region_area.default'     => '',
            'username.default'        => '',
            'phone.mobile'            => '手机格式错误！',
            'phone.require'           => '手机不能为空！',
            'verify.require'          => '验证码不能为空！',
            'password.require'        => '登录密码不能为空！',
        ]);
        if (!MessageService::instance()->checkVerifyCode($data['verify'], $data['phone'])) {
            $this->error('手机短信验证失败！');
        }
        $map = ['phone' => $data['phone'], 'deleted' => 0];
        if (DataUser::mk()->where($map)->count() > 0) {
            $this->error('手机号已注册，请使用其它手机号！');
        }
        $data['password'] = md5($data['password']);
        $user = UserAdminService::set($map, $data, $this->type, true);
        empty($user) ? $this->error('手机注册失败！') : $this->success('用户注册成功！', $user);
    }

    /**
     * 发送短信验证码
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function sendsms()
    {
        $data = $this->_vali([
            'phone.mobile'   => '手机号格式错误！',
            'phone.require'  => '手机号不能为空！',
            'secure.require' => '安全码不能为空！',
        ]);
        if ($data['secure'] !== sysconf('zt.secure_code')) $this->error('接口安全码错误！');
        [$state, $message, $data] = MessageService::instance()->sendVerifyCode($data['phone']);
        $state ? $this->success($message, $data) : $this->error($message, $data);
    }
}