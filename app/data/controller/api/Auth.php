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
     * 当前接口类型
     * 小程序使用 wxapp
     * 服务号使用 wechat
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
        $this->user = $this->getUser();
        $this->uuid = $this->user['id'];
    }

    /**
     * 获取用户数据
     * @return array|void
     */
    protected function getUser(): array
    {
        try {
            $this->type = input('api', 'web');
            $service = UserService::instance();
            if (empty($this->uuid)) {
                $token = input('token') ?: $this->request->header('token');
                if (empty($token)) $this->error('登录认证令牌不能为空！');
                [$state, $info, $this->uuid] = $service->checkUserToken($this->type, $token);
                if (empty($state)) $this->error($info, '{-null-}', 401);
            }
            return $service->get($this->type, $this->uuid);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}
