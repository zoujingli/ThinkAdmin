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
 * 修改服务器地址
 * Class Domain
 * @package WeOpen\MiniApp
 */
class Domain extends BasicWeChat
{

    /**
     * 1、设置小程序服务器域名
     * @param string $action add添加,delete删除,set覆盖,get获取。当参数是get时不需要填四个域名字段
     * @param array $data 需要的参数的数据
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function modifyDomain($action, $data = [])
    {
        $data['action'] = $action;
        $url = 'https://api.weixin.qq.com/wxa/modify_domain?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data, true);
    }

    /**
     * 2、设置小程序业务域名（仅供第三方代小程序调用）
     * @param string $action add添加, delete删除, set覆盖, get获取。
     *                       当参数是get时不需要填webviewdomain字段。
     *                       如果没有action字段参数，则默认见开放平台第三方登记的小程序业务域名全部添加到授权的小程序中
     * @param string $webviewdomain 小程序业务域名，当action参数是get时不需要此字段
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function setWebViewDomain($action, $webviewdomain)
    {
        $url = 'https://api.weixin.qq.com/wxa/setwebviewdomain?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['action' => $action, 'webviewdomain' => $webviewdomain], true);
    }

}