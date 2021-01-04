<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
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
    /** @var string */
    protected $params;

    /** @var string */
    protected $openid;

    /** @var string */
    protected $fansinfo;

    /**
     * 生成网页授权的JS内容
     * @return \think\Response
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index(): Response
    {
        $mode = $this->request->get('mode', 1);
        $source = $this->request->server('http_referer') ?: $this->request->url(true);
        $userinfo = WechatService::instance()->getWebOauthInfo($source, $mode, false);
        if (empty($userinfo['openid'])) {
            $content = 'alert("Wechat webOauth failed.")';
        } else {
            $this->openid = $userinfo['openid'];
            $this->params = json_encode(WechatService::instance()->getWebJssdkSign($source));
            $this->fansinfo = json_encode($userinfo['fansinfo'] ?? [], JSON_UNESCAPED_UNICODE);
            // 生成数据授权令牌
            $this->token = uniqid('oauth') . rand(10000, 99999);
            $this->app->cache->set($this->openid, $this->token, 3600);
            // 生成前端JS变量代码
            $content = $this->_buildContent();
        }
        return Response::create($content)->contentType('application/x-javascript');
    }

    /**
     * 给指定地址创建签名参数
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function sdk()
    {
        $data = $this->_vali(['url.require' => '签名地址不能为空！']);
        $this->success('获取签名参数', WechatService::instance()->getWebJssdkSign($data['url']));
    }

    /**
     * 生成授权内容
     * @return string
     */
    private function _buildContent(): string
    {
        return <<<EOF
if(typeof wx === 'object'){
    wx.token="{$this->token}";
    wx.openid="{$this->openid}";
    wx.fansinfo={$this->fansinfo};
    wx.config({$this->params});
    wx.ready(function(){
        wx.hideOptionMenu();
        wx.hideAllNonBaseMenuItem();
    });
}
EOF;
    }

}
