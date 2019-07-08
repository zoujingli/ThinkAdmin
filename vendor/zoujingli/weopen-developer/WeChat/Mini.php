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
 * 小程序管理权限集
 * Class Mini
 * @package WeChat
 */
class Mini extends BasicWeChat
{
    /**
     * 1. 获取公众号关联的小程序
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getLinkWxamp()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/wxamplinkget?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, [], true);
    }

    /**
     * 2. 关联小程序
     * @param string $miniAppid 小程序appid
     * @param integer $notifyUsers 是否发送模板消息通知公众号粉丝
     * @param integer $showProfile 是否展示公众号主页中
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function linkWxamp($miniAppid, $notifyUsers = 1, $showProfile = 1)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/wxopen/wxamplink?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, [
            'appid'        => $miniAppid,
            'notify_users' => $notifyUsers,
            'show_profile' => $showProfile,
        ]);
    }

    /**
     * 3.解除已关联的小程序
     * @param string $miniAppid 小程序appid
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function unlinkWxamp($miniAppid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/wxopen/wxampunlink?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['appid' => $miniAppid]);
    }

    /**
     * 第三方平台调用快速注册API完成注册
     * @param string $ticket 公众号扫码授权的凭证(公众平台扫码页面回跳到第三方平台时携带)
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function fastRegister($ticket)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/account/fastregister?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['ticket' => $ticket]);
    }

}