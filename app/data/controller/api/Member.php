<?php

namespace app\data\controller\api;

use think\admin\Controller;
use app\data\service\MemberService;
use think\exception\HttpResponseException;

/**
 * 会员管理基类
 * Class Member
 * @package app\store\controller\api
 */
abstract class Member extends Controller
{
    /**
     * 当前会员ID
     * @var integer
     */
    protected $mid;

    /**
     * 当前会员数据
     * @var array
     */
    protected $member;

    /**
     * 控制器初始化
     * @return $this
     */
    protected function initialize()
    {
        $this->mid = input('mid', '');
        $this->token = input('token', '');
        if (empty($this->mid)) $this->error('请求会员MID无效！');
        if (empty($this->token)) $this->error('接口授权TOKEN无效！');
        $this->member = $this->getMember();
        return $this;
    }

    /**
     * 获取会员数据
     * @return array
     */
    protected function getMember()
    {
        try {
            $this->member = MemberService::instance()->get($this->mid);
            if ($this->member['token'] !== $this->token) {
                $this->error('无效的授权，请重新登录授权！');
            }
            return $this->member;
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}
