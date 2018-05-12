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
use WeChat\Exceptions\InvalidResponseException;
use WeChat\Receive;

/**
 * 第三方平台支持
 * Class Service
 * @package WeOpen
 */
class Service
{
    /**
     * 当前配置对象
     * @var DataArray
     */
    protected $config;

    /**
     * Service constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (empty($options['component_token'])) {
            throw new InvalidArgumentException("Missing Config -- [component_token]");
        }
        if (empty($options['component_appid'])) {
            throw new InvalidArgumentException("Missing Config -- [component_appid]");
        }
        if (empty($options['component_appsecret'])) {
            throw new InvalidArgumentException("Missing Config -- [component_appsecret]");
        }
        if (empty($options['component_encodingaeskey'])) {
            throw new InvalidArgumentException("Missing Config -- [component_encodingaeskey]");
        }
        if (!empty($options['cache_path'])) {
            Tools::$cache_path = $options['cache_path'];
        }
        $this->config = new DataArray($options);
    }

    /**
     * 接收公众平台推送的 Ticket
     * @return bool|array
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getComonentTicket()
    {
        $receive = new Receive([
            'token'          => $this->config->get('component_token'),
            'appid'          => $this->config->get('component_appid'),
            'appsecret'      => $this->config->get('component_appsecret'),
            'encodingaeskey' => $this->config->get('component_encodingaeskey'),
            'cache_path'     => $this->config->get('cache_path'),
        ]);
        $data = $receive->getReceive();
        if (!empty($data['ComponentVerifyTicket'])) {
            Tools::setCache('component_verify_ticket', $data['ComponentVerifyTicket']);
        }
        return $data;
    }

    /**
     * 获取或刷新服务 AccessToken
     * @return bool|string
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getComponentAccessToken()
    {
        $cache = 'wechat_component_access_token';
        if (($component_access_token = Tools::getCache($cache))) {
            return $component_access_token;
        }
        $data = [
            'component_appid'         => $this->config->get('component_appid'),
            'component_appsecret'     => $this->config->get('component_appsecret'),
            'component_verify_ticket' => Tools::getCache('component_verify_ticket'),
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
        $result = $this->httpPostForJson($url, $data);
        if (empty($result['component_access_token'])) {
            throw new InvalidResponseException($result['errmsg'], $result['errcode'], $data);
        }
        Tools::setCache($cache, $result['component_access_token'], 7000);
        return $result['component_access_token'];
    }

    /**
     * 获取授权方的帐号基本信息
     * @param string $authorizer_appid 授权公众号或小程序的appid
     * @return array
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getAuthorizerInfo($authorizer_appid)
    {
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token={$component_access_token}";
        $data = [
            'authorizer_appid' => $authorizer_appid,
            'component_appid'  => $this->config->get('component_appid'),
        ];
        $result = $this->httpPostForJson($url, $data);
        if (empty($result['authorizer_info'])) {
            throw new InvalidResponseException($result['errmsg'], $result['errcode'], $data);
        }
        return $result['authorizer_info'];
    }

    /**
     * 设置授权方的选项信息
     * @param string $authorizer_appid 授权公众号或小程序的appid
     * @param string $option_name 选项名称
     * @param string $option_value 设置的选项值
     * @return array
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function setAuthorizerOption($authorizer_appid, $option_name, $option_value)
    {
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/component/ api_set_authorizer_option?component_access_token={$component_access_token}";
        $result = $this->httpPostForJson($url, [
            'option_name'      => $option_name,
            'option_value'     => $option_value,
            'authorizer_appid' => $authorizer_appid,
            'component_appid'  => $this->config->get('component_appid'),
        ]);
        return $result;
    }

    /**
     * 获取预授权码 pre_auth_code
     * @return string
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getPreauthCode()
    {
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$component_access_token}";
        $result = $this->httpPostForJson($url, ['component_appid' => $this->config->get('component_appid')]);
        if (empty($result['pre_auth_code'])) {
            throw new InvalidResponseException('GetPreauthCode Faild.', '0', $result);
        }
        return $result['pre_auth_code'];
    }

    /**
     * 获取授权回跳地址
     * @param string $redirect_uri 回调URI
     * @param integer $auth_type 要授权的帐号类型
     * @return bool
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getAuthRedirect($redirect_uri, $auth_type = 3)
    {
        $redirect_uri = urlencode($redirect_uri);
        $pre_auth_code = $this->getPreauthCode();
        $component_appid = $this->config->get('component_appid');
        return "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$component_appid}&pre_auth_code={$pre_auth_code}&redirect_uri={$redirect_uri}&auth_type={$auth_type}";
    }

    /**
     * 使用授权码换取公众号或小程序的接口调用凭据和授权信息
     * @param null $auth_code 授权码
     * @return bool|array
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getQueryAuthorizerInfo($auth_code = null)
    {
        if (is_null($auth_code) && isset($_GET['auth_code'])) {
            $auth_code = $_GET['auth_code'];
        }
        if (empty($auth_code)) {
            return false;
        }
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token={$component_access_token}";
        $data = [
            'component_appid'    => $this->config->get('component_appid'),
            'authorization_code' => $auth_code,
        ];
        $result = $this->httpPostForJson($url, $data);
        if (empty($result['authorization_info'])) {
            throw new InvalidResponseException($result['errmsg'], $result['errcode'], $data);
        }
        $authorizer_appid = $result['authorization_info']['authorizer_appid'];
        $authorizer_access_token = $result['authorization_info']['authorizer_access_token'];
        // 缓存授权公众号访问 ACCESS_TOKEN
        Tools::setCache("{$authorizer_appid}_access_token", $authorizer_access_token, 7000);
        return $result['authorization_info'];
    }

    /**
     * 获取（刷新）授权公众号的令牌
     * @param string $authorizer_appid 授权公众号或小程序的appid
     * @param string $authorizer_refresh_token 授权方的刷新令牌
     * @return array
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function refreshAccessToken($authorizer_appid, $authorizer_refresh_token)
    {
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token={$component_access_token}";
        $data = [
            'authorizer_appid'         => $authorizer_appid,
            'authorizer_refresh_token' => $authorizer_refresh_token,
            'component_appid'          => $this->config->get('component_appid'),
        ];
        $result = $this->httpPostForJson($url, $data);
        if (empty($result['authorizer_access_token'])) {
            throw new InvalidResponseException($result['errmsg'], $result['errcode'], $data);
        }
        // 缓存授权公众号访问 ACCESS_TOKEN
        Tools::setCache("{$authorizer_appid}_access_token", $result['authorizer_access_token'], 7000);
        return $result;
    }

    /**
     * oauth 授权跳转接口
     * @param string $authorizer_appid 授权公众号或小程序的appid
     * @param string $redirect_uri 回调地址
     * @param string $scope snsapi_userinfo|snsapi_base
     * @return string
     */
    public function getOauthRedirect($authorizer_appid, $redirect_uri, $scope = 'snsapi_userinfo')
    {
        $redirect_url = urlencode($redirect_uri);
        $component_appid = $this->config->get('component_appid');
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$authorizer_appid}&redirect_uri={$redirect_url}&response_type=code&scope={$scope}&state={$authorizer_appid}&component_appid={$component_appid}#wechat_redirect";
    }

    /**
     * 通过code获取AccessToken
     * @param string $authorizer_appid 授权公众号或小程序的appid
     * @return bool|array
     * @throws InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getOauthAccessToken($authorizer_appid)
    {
        if (empty($_GET['code'])) {
            return false;
        }
        $component_appid = $this->config->get('component_appid');
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/sns/oauth2/component/access_token?appid={$authorizer_appid}&code={$_GET['code']}&grant_type=authorization_code&component_appid={$component_appid}&component_access_token={$component_access_token}";
        return $this->httpGetForJson($url);
    }

    /**
     * 取当前所有已授权的帐号基本信息
     * @param integer $count 拉取数量，最大为500
     * @param integer $offset 偏移位置/起始位置
     * @return array|bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getAuthorizerList($count = 500, $offset = 0)
    {
        $component_appid = $this->config->get('component_appid');
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_list?component_access_token={$component_access_token}";
        return $this->httpPostForJson($url, [
            'count'           => $count,
            'offset'          => $offset,
            'component_appid' => $component_appid,
        ]);
    }

    /**
     * 创建指定授权公众号接口实例
     * @param string $name 需要加载的接口实例名称
     * @param string $authorizer_appid 授权公众号的appid
     * @param string $type 加载SDK类型 WeChat|WeMini
     * @return \WeChat\Card|\WeChat\Custom|\WeChat\Media|\WeChat\Menu|\WeChat\Oauth|\WeChat\Pay|\WeChat\Product|\WeChat\Qrcode|\WeChat\Receive|\WeChat\Scan|\WeChat\Script|\WeChat\Shake|\WeChat\Tags|\WeChat\Template|\WeChat\User|\WeChat\Wifi
     */
    public function instance($name, $authorizer_appid, $type = 'WeChat')
    {
        $className = "{$type}\\" . ucfirst(strtolower($name));
        return new $className($this->getConfig($authorizer_appid));
    }

    /**
     * 获取授权公众号配置参数
     * @param string $authorizer_appid 授权公众号的appid
     * @return array
     */
    public function getConfig($authorizer_appid)
    {
        $config = $this->config->get();
        $config['appid'] = $authorizer_appid;
        $config['token'] = $this->config->get('component_token');
        $config['appsecret'] = $this->config->get('component_appsecret');
        $config['encodingaeskey'] = $this->config->get('component_encodingaeskey');
        return $config;
    }

    /**
     * 以POST获取接口数据并转为数组
     * @param string $url 接口地址
     * @param array $data 请求数据
     * @param bool $buildToJson
     * @return array
     */
    protected function httpPostForJson($url, array $data, $buildToJson = true)
    {
        return json_decode(Tools::post($url, $buildToJson ? Tools::arr2json($data) : $data), true);
    }

    /**
     * 以GET获取接口数据并转为数组
     * @param string $url 接口地址
     * @return array
     */
    protected function httpGetForJson($url)
    {
        return json_decode(Tools::get($url), true);
    }

}