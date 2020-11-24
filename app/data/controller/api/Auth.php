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
     * 当前用户UID
     * @var int
     */
    protected $uuid;

    /**
     * 当前用户数据
     * @var array
     */
    protected $user;

    /**
     * 当前接口类型
     * @var string
     */
    protected $type = 'wxapp';

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
    protected function getUser()
    {
        try {
            if (empty($this->uuid)) {
                $token = input('token') ?: $this->request->header('token');
                if (empty($token)) $this->error('接口认证令牌不能为空！');
                [$state, $message, $this->uuid] = UserService::instance()->checkUserToken($this->type, $token);
                if ($state) $this->error($message);
            }
            return UserService::instance()->get($this->type, $this->uuid);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}
