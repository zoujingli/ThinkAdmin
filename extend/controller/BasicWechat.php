<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace controller;

use service\WechatService;
use think\Controller;
use think\Log;

/**
 * 微信基础控制器
 * Class BasicWechat
 * @package controller
 */
class BasicWechat extends Controller {

    /**
     * 当前粉丝用户OPENID
     * @var string
     */
    protected $openid;

    /**
     * 当前粉丝信息
     * @var array
     */
    protected $fansinfo;

    /**
     * 当前访问网址
     * @var string
     */
    protected $url;

    /**
     * 是否默认开启网页授权
     * @var bool
     */
    protected $checkAuth = true;

    /**
     * 初始化方法
     */
    public function _initialize() {
        // 当前完整URL地址
        $this->url = $this->request->url(true);
        // 网页授权，并获粉丝信息
        $this->assign('jsSign', load_wechat('script')->getJsSign($this->url));
        // 检查启用网页授权
        $this->checkAuth && $this->oAuth();
    }

    /**
     * 微信网页授权
     * @param bool $fullMode 获取完整
     * @return string
     */
    protected function oAuth($fullMode = true) {
        // 本地开发调试用户 openid
        if (in_array($this->request->host(), ['127.0.0.1', 'localhost'])) {
            session('openid', 'oBWB3wWVNujb-PJlmPmxC5CBTNF0');
        }
        // 检查缓存中 openid 信息是否完整
        if (($this->openid = session('openid'))) {
            if (!$fullMode) {
                return $this->openid;
            }
            $this->fansinfo = WechatService::getFansInfo($this->openid);
            if (!empty($this->fansinfo) && $this->fansinfo['expires_in'] > time()) {
                $this->assign('fansinfo', $this->fansinfo);
                return $this->openid;
            }
        }
        // 发起微信网页授权
        $wxoauth_url = $this->url;
        if (!($redirect_url = $this->request->get('redirectcode', false, 'decode'))) {
            $split = stripos($this->url, '?') === false ? '?' : '&';
            $wxoauth_url = "{$this->url}{$split}redirectcode=" . encode($this->url);
        }
        // 微信网页授权处理
        $wechat = &load_wechat('Oauth');
        if (!$this->request->get('code', false)) {
            $this->redirect($wechat->getOauthRedirect($wxoauth_url, 'webOauth', 'snsapi_base'));
        }
        if (FALSE === ($result = $wechat->getOauthAccessToken()) || empty($result['openid'])) {
            Log::error("微信网页授权失败, {$wechat->errMsg}[{$wechat->errCode}]");
            $this->error("微信网页授权失败, {$wechat->errMsg}[{$wechat->errCode}]");
        }
        session('openid', $this->openid = $result['openid']);
        empty($fullMode) && $this->redirect($redirect_url);
        // 微信粉丝信息处理
        $this->fansinfo = WechatService::getFansInfo($this->openid);
        if (empty($this->fansinfo['expires_in']) || intval($this->fansinfo['expires_in']) < time()) {
            /* 使用普通授权, 获取用户资料; 未关注时重新使用高级授权 */
            if ($result['scope'] === 'snsapi_base') :
                $user = load_wechat('User')->getUserInfo($this->openid);
                empty($user['subscribe']) && $this->redirect($wechat->getOauthRedirect($wxoauth_url, 'webOauth', 'snsapi_userinfo'));
            /* 使用高级授权, 获取完整用户资料 */
            elseif ($result['scope'] === 'snsapi_userinfo') :
                $user = $wechat->getOauthUserinfo($result['access_token'], $this->openid);
            endif;
            /* 授权结果处理, 更新粉丝信息 */
            if ((empty($user) || !array_key_exists('nickname', $user))) :
                Log::error("微信网页授权获取用户信息失败, {$wechat->errMsg}[{$wechat->errCode}]");
                $this->error("微信网页授权获取用户信息失败, {$wechat->errMsg}[{$wechat->errCode}]");
            endif;
            $user['expires_in'] = $result['expires_in'] + time() - 100;
            $user['refresh_token'] = $result['refresh_token'];
            $user['access_token'] = $result['access_token'];
            WechatService::setFansInfo($user, $wechat->appid) or $this->error('微信网页授权用户保存失败!');
        }
        $this->redirect($redirect_url);
    }

}
