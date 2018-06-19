<?php

// +----------------------------------------------------------------------
// | WeChatDeveloper
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

namespace WeOpen;

use WeChat\Contracts\DataArray;
use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidArgumentException;

/**
 * 网站应用微信登录
 * Class Login
 * @package WeOpen
 */
class Login
{
    /**
     * 当前配置对象
     * @var DataArray
     */
    protected $config;

    /**
     * Login constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->config = new DataArray($options);
        if (empty($options['appid'])) {
            throw new InvalidArgumentException("Missing Config -- [appid]");
        }
        if (empty($options['appsecret'])) {
            throw new InvalidArgumentException("Missing Config -- [appsecret]");
        }
    }

    /**
     * 第一步：请求CODE
     * @param string $redirectUri 请使用urlEncode对链接进行处理
     * @return string
     */
    public function auth($redirectUri)
    {
        $appid = $this->config->get('appid');
        $redirectUri = urlencode($redirectUri);
        return "https://open.weixin.qq.com/connect/qrconnect?appid={$appid}&redirect_uri={$redirectUri}&response_type=code&scope=snsapi_login&state={$appid}#wechat_redirect";
    }

    /**
     * 第二步：通过code获取access_token
     * @return mixed
     */
    public function getAccessToken()
    {
        $appid = $this->config->get('appid');
        $secret = $this->config->get('appsecret');
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";
        return json_decode(Tools::get($url));
    }

    /**
     * 刷新AccessToken有效期
     * @param string $refreshToken
     * @return array
     */
    public function refreshToken($refreshToken)
    {
        $appid = $this->config->get('appid');
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$appid}&grant_type=refresh_token&refresh_token={$refreshToken}";
        return json_decode(Tools::get($url));
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * @param string $accessToken 调用凭证
     * @param string $openid 普通用户的标识，对当前开发者帐号唯一
     * @return array
     */
    public function checkAccessToken($accessToken, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/auth?access_token={$accessToken}&openid={$openid}";
        return json_decode(Tools::get($url));
    }

    /**
     * 获取用户个人信息（UnionID机制）
     * @param string $accessToken 调用凭证
     * @param string $openid 普通用户的标识，对当前开发者帐号唯一
     * @return array
     */
    public function getUserinfo($accessToken, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openid}";
        return json_decode(Tools::get($url));
    }

}