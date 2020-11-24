<?php

namespace app\data\controller\api;

use app\data\service\UserService;
use think\admin\Controller;
use think\exception\HttpResponseException;

/**
 * 授权认证基类
 * Class Member
 * @package app\store\controller\api
 */
abstract class Auth extends Controller
{
    /**
     * 当前用户UID
     * @var int
     */
    protected $uid;

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
        $this->uid = $this->user['id'];
    }

    /**
     * 获取用户数据
     * @return array|void
     */
    protected function getUser()
    {
        try {
            $this->token = input('token') ?: $this->request->header('token');
            if (empty($this->token)) $this->error('接口请求认证令牌不能为空！');
            return UserService::instance()->get(['token' => $this->token]);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}
