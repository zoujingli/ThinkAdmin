<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace controller;

use service\FansService;
use think\Controller;

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
    protected $current;

    /**
     * 是否默认开启网页授权
     * @var bool
     */
    protected $check_auth = true;

    /**
     * 初始化方法
     */
    public function _initialize() {
        parent::_initialize();
        $this->current = ($this->request->isSsl() ? 'https' : 'http') . '://' . $this->request->host() . $this->request->url();
        /* 网页授权，并获粉丝信息 */
        if ($this->check_auth && $this->oAuth()) {
            if ($this->request->isGet()) {
                $this->assign('js_sign', load_wechat('script')->getJsSign($this->current));
                $this->assign('fansinfo', $this->fansinfo);
            }
        }
    }

    /**
     * 微信网页授权函数
     * @param bool $isfull
     * @return string
     */
    protected function oAuth($isfull = true) {
        $host = $this->request->host();
        # 本地开发调试用户OPENID
        if (in_array($host, ['127.0.0.1', 'localhost'])) {
            session('openid', 'o38gps1Unf64JOTdxNdd424lsEmM');
        }
        # 检查缓存中openid信息是否完整
        if (!!($this->openid = session('openid'))) {
            if (!!($this->fansinfo = FansService::get($this->openid)) || !$isfull) {
                return $this->openid;
            }
        }
        # 发起微信网页授权
        $wxoauth_url = $this->current;
        if (!($redirect_url = $this->request->get('redirecturl', false, 'decode'))) {
            $params = $this->request->param();
            $params['redirecturl'] = encode($wxoauth_url);
            $wxoauth_url = url($this->request->baseUrl(), '', false, true) . '?' . http_build_query($params);
        }
        $wechat = &load_wechat('Oauth');
        # 微信网页授权处理
        if (!$this->request->get('code', false)) {
            exit(redirect($wechat->getOauthRedirect($wxoauth_url, 'webOauth', 'snsapi_base'))->send());
        }
        if (FALSE === ($result = $wechat->getOauthAccessToken()) || empty($result['openid'])) {
            Log::error("微信授权失败 [ {$wechat->errMsg} ]");
            exit('网页授权失败，请稍候再试！');
        }
        session('openid', $this->openid = $result['openid']);
        $this->fansinfo = FansService::get($this->openid);
        # 微信粉丝信息处理
        if (empty($this->fansinfo['expires_in']) || $this->fansinfo['expires_in'] < time()) {
            switch ($result['scope']) {
                case 'snsapi_base': /* 普通授权，获取用户资料；未关注时重新使用高级授权 */
                    $user = load_wechat('User')->getUserInfo($this->openid);
                    if ($isfull && empty($user['subscribe'])) {
                        exit(redirect($wechat->getOauthRedirect($wxoauth_url, 'webOauth', 'snsapi_userinfo'))->send());
                    }
                    break;
                case 'snsapi_userinfo': /* 高级授权，获取用户资料 */
                    $user = $wechat->getOauthUserinfo($result['access_token'], $this->openid);
                    break;
            }
            if ($isfull && (empty($user) || !array_key_exists('nickname', $user))) {
                exit("微信授权失败 [{$wechat->errMsg}]!");
            }
            /* 更新粉丝信息 */
            $user['expires_in'] = $result['expires_in'] + time() - 100;
            $user['refresh_token'] = $result['refresh_token'];
            $user['access_token'] = $result['access_token'];
            !FansService::set($user) && exit('微信授权失败 [ save userinfo faild ]');
            $this->fansinfo = FansService::get($this->openid);
        }
        empty($this->fansinfo) && exit('获取微信用户信息失败！');
        !!$redirect_url && exit(redirect($redirect_url)->send());
        return $this->openid;
    }

}
