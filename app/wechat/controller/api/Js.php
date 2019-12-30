<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\service\WechatService;
use think\admin\Controller;
use think\Response;

/**
 * 前端JS获取控制器
 * Class Js
 * @package app\wechat\controller\api
 */
class Js extends Controller
{
    /**
     * 返回生成的JS内容
     * @return \think\Response
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->mode = $this->request->get('mode', 1);
        $this->source = $this->request->server('http_referer', $this->request->url(true));
        $user = WechatService::instance()->getWebOauthInfo($this->source, $this->mode, false);
        if (empty($user['openid'])) {
            $content = 'alert("Wechat webOauth failed.")';
        } else {
            $this->openid = $user['openid'];
            $this->config = json_encode(WechatService::instance()->getWebJssdkSign($this->source));
            $this->fansinfo = json_encode(empty($user['fansinfo']) ? [] : $user['fansinfo'], JSON_UNESCAPED_UNICODE);
            // 生成接口授权令牌
            $this->token = uniqid('oauth') . rand(10000, 99999);
            $this->app->cache->set($this->openid, $this->token, 3600);
            $content = $this->_buildContent();
        }
        return Response::create($content)->contentType('application/x-javascript');
    }

    /**
     * 生成授权内容
     * @return string
     */
    private function _buildContent()
    {
        return <<<EOF
if(typeof wx === 'object'){
    wx.token="{$this->token}";
    wx.openid="{$this->openid}";
    wx.fansinfo={$this->fansinfo};
    wx.config({$this->config});
    wx.ready(function(){
        wx.hideOptionMenu();
        wx.hideAllNonBaseMenuItem();
    });
}
EOF;
    }

}
