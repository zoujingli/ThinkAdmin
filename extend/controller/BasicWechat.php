<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace controller;

use app\store\service\MemberService;
use service\WechatService;
use think\Controller;
use think\Db;

/**
 * 微信基础控制器
 * Class BasicWechat
 * @package controller
 */
class BasicWechat extends Controller
{

    /**
     * 当前粉丝用户OPENID
     * @var string
     */
    protected $openid;

    /**
     * 当前会员数据记录
     * @var array
     */
    protected $member = [];

    /**
     * 初始化会员数据记录
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @return array
     */
    protected function initMember()
    {
        $openid = $this->getOpenid();
        $this->member = Db::name('StoreMember')->where(['openid' => $openid])->find();
        if (empty($this->member)) {
            MemberService::create(['openid' => $openid]);
            $this->member = Db::name('StoreMember')->where(['openid' => $openid])->find();
        }
        return $this->member;
    }

    /**
     * 获取粉丝用户OPENID
     * @return bool|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function getOpenid()
    {
        $url = $this->request->url(true);
        return WechatService::webOauth($url, 0)['openid'];
    }

    /**
     * 获取微信粉丝信息
     * @return bool|array
     * @throws \Exception
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function getFansinfo()
    {
        $url = $this->request->url(true);
        return WechatService::webOauth($url, 1)['fansinfo'];
    }

}
