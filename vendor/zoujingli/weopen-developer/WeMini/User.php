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

namespace WeMini;

use WeChat\Contracts\BasicWeChat;

/**
 * 微信开放平台帐号管理
 * Class Template
 * @package WeOpen\MiniApp
 */
class User extends BasicWeChat
{
    /**
     * 1. 创建开放平台帐号并绑定公众号/小程序
     * @param string $appid 授权公众号或小程序的 appid
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function create($appid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/open/create?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $appid], true);
    }

    /**
     * 2. 将公众号/小程序绑定到开放平台帐号下
     * @param string $appid 授权公众号或小程序的appid
     * @param string $openAppid 开放平台帐号appid
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function bind($appid, $openAppid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/open/bind?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $appid, 'open_appid' => $openAppid]);
    }

    /**
     * 3. 将公众号/小程序从开放平台帐号下解绑
     * @param string $appid 授权公众号或小程序的appid
     * @param string $openAppid 开放平台帐号appid
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function unbind($appid, $openAppid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/open/unbind?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $appid, 'open_appid' => $openAppid]);
    }

    /**
     * 3. 获取公众号/小程序所绑定的开放平台帐号
     * @param string $appid 授权公众号或小程序的appid
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function get($appid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/open/unbind?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $appid]);
    }
}