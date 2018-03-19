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

namespace app\index\controller;

use service\WechatService;
use think\Controller;

/**
 * 公众号测试
 * Class Wechat
 * @package app\index\controller
 */
class Wechat extends Controller
{
    /**
     * 网页授权测试
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function oauth()
    {
        $fans = WechatService::webOauth(1);
        return $this->fetch('wechat@api/tools/oauth', ['fans' => $fans]);
    }

    /**
     * 网页JSSDK测试
     * @return mixed
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function jssdk()
    {
        return $this->fetch('wechat@api/tools/jssdk', ['options' => WechatService::webJsSDK()]);
    }
}