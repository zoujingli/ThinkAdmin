<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\service\Wechat;
use library\Controller;
use think\facade\Response;

/**
 * 前端JS获取控制器
 * Class Js
 * @package app\wechat\controller\api
 */
class Js extends Controller
{
    /**
     * 返回生成的JS内容
     * @return \think\response
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $url = $this->request->server('http_referer', $this->request->url(true), null);
        $wechat = Wechat::getWebOauthInfo($url, $this->request->get('mode', 1), false);
        $openid = isset($wechat['openid']) ? $wechat['openid'] : '';
        $unionid = empty($wechat['fansinfo']['unionid']) ? '' : $wechat['fansinfo']['unionid'];
        $configJson = json_encode(Wechat::getWebJssdkSign($url), JSON_UNESCAPED_UNICODE);
        $fansinfoJson = json_encode(isset($wechat['fansinfo']) ? $wechat['fansinfo'] : [], JSON_UNESCAPED_UNICODE);
        $html = <<<EOF
if(typeof wx==='object'){
    wx.openid="{$openid}";
    wx.unionid="{$unionid}";
    wx.config({$configJson});
    wx.fansinfo={$fansinfoJson};
    wx.ready(function(){
        wx.hideOptionMenu();
        wx.hideAllNonBaseMenuItem();
    });
}
EOF;
        return Response::create($html)->contentType('application/x-javascript');
    }

}