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
     * 当前会员MID
     * @var int
     */
    protected $mid;

    /**
     * 接口授权令牌
     * @var string
     */
    protected $token;

    /**
     * 当前会员数据
     * @var array
     */
    protected $member;

    /**
     * 控制器初始化
     */
    protected function initialize()
    {
        $this->token = $this->request->request('token', '');
        if (empty($this->token)) {
            $this->token = $this->request->header('token', '');
        }
        if (empty($this->token)) {
            $this->error('请求令牌不能为空！');
        }
        $this->member = $this->getMember();
        $this->mid = $this->member['id'];
    }

    /**
     * 获取会员数据
     * @return array|void
     */
    protected function getMember()
    {
        try {
            $map = ['token' => $this->token];
            return UserService::instance()->get($map);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}
