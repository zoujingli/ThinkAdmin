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
 * 基础信息设置
 * Class Basic
 * @package WeOpen\MiniApp
 */
class Basic extends BasicWeChat
{

    /**
     * 1. 设置小程序隐私设置（是否可被搜索）
     * @param integer $status 1表示不可搜索，0表示可搜索
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function changeWxaSearchStatus($status)
    {
        $url = 'https://api.weixin.qq.com/wxa/changewxasearchstatus?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['status' => $status], true);
    }

    /**
     * 2. 查询小程序当前隐私设置（是否可被搜索）
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getWxaSearchStatus()
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxasearchstatus?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

}