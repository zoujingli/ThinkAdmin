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

use service\ToolsService;
use service\WechatService;
use think\facade\Response;

/**
 * 微信公众号页面脚本
 * Class Script
 * @package app\wechat\controller\api
 */
class Script
{

    /**
     * 当前请求对象
     * @var \think\Request
     */
    protected $request;


    /**
     * Wechat constructor.
     */
    public function __construct()
    {
        ToolsService::corsOptionsHandler();
        $this->request = app('request');
    }

    /**
     * jsSign签名
     * @throws \Exception
     */
    public function index()
    {
        $wechat = WechatService::webOauth($this->request->get('mode', 1));
        $url = $this->request->server('HTTP_REFERER', $this->request->url(true), null);
        $assign = [
            'openid'   => $wechat['openid'],
            'fansinfo' => $wechat['fansinfo'],
            'jssdk'    => WechatService::webJsSDK($url),
        ];
        return Response::create(env('APP_PATH') . 'wechat/view/api/script/index.js', 'view', 200, [
            'content-type'  => 'application/x-javascript;charset=utf-8',
            'cache-control' => 'no-cache', 'pragma' => 'no-cache', 'expires' => '0',
        ])->assign($assign);
    }
}