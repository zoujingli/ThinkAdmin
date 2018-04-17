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

namespace app\wechat\controller\api;

use service\WechatService;
use think\facade\Response;

/**
 * 公众号页面支持
 * Class Script
 * @package app\wechat\controller\api
 */
class Js
{

    /**
     * jsSign签名
     * @return mixed
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $result = app('request');
        $url = $result->server('HTTP_REFERER', $result->url(true), null);
        $wechat = WechatService::webOauth($url, $result->get('mode', 1), false);
        $assign = [
            'jssdk'  => WechatService::webJsSDK($url),
            'openid' => $wechat['openid'], 'fansinfo' => $wechat['fansinfo'],
        ];
        return Response::create(env('APP_PATH') . 'wechat/view/api/script/index.js', 'view', 200, [
            'Content-Type'  => 'application/x-javascript',
            'Cache-Control' => 'no-cache', 'Pragma' => 'no-cache', 'Expires' => '0',
        ])->assign($assign);
    }
}