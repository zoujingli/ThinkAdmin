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

namespace WeChat;

use WeChat\Contracts\BasicWeChat;

/**
 * 微信开放平台帐号管理
 * Class Bind
 * @package WeChat
 */
class Bind extends BasicWeChat
{
    /**
     * 创建开放平台帐号并绑定公众号
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function create()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/open/create?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $this->config->get('appid')]);
    }

    /**
     * 将公众号绑定到开放平台帐号下
     * @param string $openidAppid 开放平台帐号APPID
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function link($openidAppid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/open/bind?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $this->config->get('appid'), 'open_appid' => $openidAppid]);
    }

    /**
     * 将公众号从开放平台帐号下解绑
     * @param string $openidAppid 开放平台帐号APPID
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function unlink($openidAppid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/open/unbind?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $this->config->get('appid'), 'open_appid' => $openidAppid]);
    }

    /**
     * 获取公众号所绑定的开放平台帐号
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function get()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/open/get?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $this->config->get('appid')]);
    }

}