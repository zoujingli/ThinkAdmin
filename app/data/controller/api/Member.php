<?php

namespace app\data\controller\api;

use app\data\service\MemberService;
use think\admin\Controller;
use think\exception\HttpResponseException;

/**
 * 会员管理基类
 * Class Member
 * @package app\store\controller\api
 */
abstract class Member extends Controller
{
    /**
     * 当前会员MID
     * @var int
     */
    protected $mid;

    /**
     * 接口授权TOKEN
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
        $this->token = input('token', '');
        $this->member = $this->getMember();
        $this->mid = $this->member['id'];
    }

    /**
     * 获取会员数据
     * @return array
     */
    protected function getMember()
    {
        try {
            if (empty($this->token)) {
                $this->error('接口授权TOKEN无效');
            }
            return MemberService::instance()->get($this->token);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}
