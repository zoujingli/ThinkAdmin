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
 * 成员管理
 * Class Tester
 * @package WeOpen\MiniApp
 */
class Tester extends BasicWeChat
{

    /**
     * 1、绑定微信用户为小程序体验者
     * @param string $testid 微信号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function bindTester($testid)
    {
        $url = 'https://api.weixin.qq.com/wxa/bind_tester?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['wechatid' => $testid], true);
    }

    /**
     * 2、解除绑定小程序的体验者
     * @param string $testid 微信号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function unbindTester($testid)
    {
        $url = 'https://api.weixin.qq.com/wxa/unbind_tester?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['wechatid' => $testid], true);
    }

    /**
     * 3. 获取体验者列表
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getTesterList()
    {
        $url = 'https://api.weixin.qq.com/wxa/memberauth?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['action' => 'get_experiencer'], true);
    }

}