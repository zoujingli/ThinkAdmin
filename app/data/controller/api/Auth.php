<?php

namespace app\data\controller\api;

use app\data\service\UserService;
use think\admin\Controller;
use think\exception\HttpResponseException;

/**
 * 授权认证基类
 * Class Auth
 * @package app\store\controller\api
 */
abstract class Auth extends Controller
{
    /**
     * 当前接口请求终端类型
     * --- 手机浏览器访问 wap
     * --- 电脑浏览器访问 web
     * --- 微信小程序访问 wxapp
     * --- 微信服务号访问 wechat
     * --- 苹果应用接口访问 isoapp
     * --- 安卓应用接口访问 android
     * @var string
     */
    protected $type;

    /**
     * 当前用户编号
     * @var integer
     */
    protected $uuid;

    /**
     * 当前用户数据
     * @var array
     */
    protected $user;

    /**
     * 控制器初始化
     */
    protected function initialize()
    {
        // 接口数据类型
        $this->type = input('api') ?: $this->request->header('api-name');
        $this->type = $this->type ?: $this->request->header('api-type');
        if (empty($this->type) || empty(UserService::TYPES[$this->type])) {
            $this->error("接口通道未定义！");
        }
        // 获取用户数据
        $this->user = $this->getUser();
        $this->uuid = $this->user['id'] ?? '';
        if (empty($this->uuid)) {
            $this->error('用户登录失败！', '{-null-}', 401);
        }
    }

    /**
     * 获取用户数据
     * @return array
     */
    protected function getUser(): array
    {
        try {
            if (empty($this->uuid)) {
                $token = input('token') ?: $this->request->header('api-token');
                if (empty($token)) $this->error('登录认证TOKEN不能为空！');
                [$state, $info, $this->uuid] = UserService::instance()->check($this->type, $token);
                if (empty($state)) $this->error($info, '{-null-}', 401);
            }
            return UserService::instance()->get($this->type, $this->uuid);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}
