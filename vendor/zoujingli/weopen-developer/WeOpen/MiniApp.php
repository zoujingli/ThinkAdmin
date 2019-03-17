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

use WeChat\Contracts\Tools;

/**
 * 公众号小程序授权支持
 * Class MiniApp
 * @package WeOpen
 */
class MiniApp extends Service
{

    /**
     * code换取session_key
     * @param string $appid 小程序的AppID
     * @param string $code 登录时获取的code
     * @return mixed
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function session($appid, $code)
    {
        $component_appid = $this->config->get('component_appid');
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/sns/component/jscode2session?appid={$appid}&js_code={$code}&grant_type=authorization_code&component_appid={$component_appid}&component_access_token={$component_access_token}";
        return json_decode(Tools::get($url), true);
    }

    /**
     * 1.注册流程及接口说明
     * @param string $authorizerAppid 公众号的appid
     * @param integer $copyWxVerify 是否复用公众号的资质进行微信认证(1:申请复用资质进行微信 认证 0:不申请)
     * @param string $redirectUri 用户扫码授权后，MP 扫码页面将跳转到该地址(注:1.链接需 urlencode 2.Host 需和第三方平台在微信开放平台上面填写的登 录授权的发起页域名一致)
     * @return string
     */
    public function getCopyRegisterMiniUrl($authorizerAppid, $copyWxVerify, $redirectUri)
    {
        $redirectUri = urlencode($redirectUri);
        $componentAppid = $this->config->get('component_appid');
        return "https://mp.weixin.qq.com/cgi-bin/fastregisterauth?appid={$authorizerAppid}&component_appid={$componentAppid}&copy_wx_verify={$copyWxVerify}&redirect_uri={$redirectUri}";
    }


    /**
     * 2.7.1 从第三方平台跳转至微信公众平台授权注册页面
     * @param string $authorizerAppid 公众号的 appid
     * @param string $redirectUri 新管理员信息填写完成点击提交后，将跳转到该地址
     * @return string
     */
    public function getComponentreBindAdmin($authorizerAppid, $redirectUri)
    {
        $redirectUri = urlencode($redirectUri);
        $componentAppid = $this->config->get('component_appid');
        return "https://mp.weixin.qq.com/wxopen/componentrebindadmin?appid={$authorizerAppid}&component_appid={$componentAppid}&redirect_uri={$redirectUri}";
    }

    /**
     * 1、获取草稿箱内的所有临时代码草稿
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getTemplateDraftList()
    {
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/wxa/gettemplatedraftlist?access_token={$component_access_token}";
        return $this->httpGetForJson($url);
    }

    /**
     * 2、获取代码模版库中的所有小程序代码模版
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getTemplateList()
    {
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/wxa/gettemplatelist?access_token={$component_access_token}";
        return $this->httpGetForJson($url);
    }

    /**
     * 3、将草稿箱的草稿选为小程序代码模版
     * @param integer $draft_id 草稿ID，本字段可通过“ 获取草稿箱内的所有临时代码草稿 ”接口获得
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function addToTemplate($draft_id)
    {
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/wxa/addtotemplate?access_token={$component_access_token}";
        return $this->httpPostForJson($url, ['draft_id' => $draft_id]);
    }

    /**
     * 4、删除指定小程序代码模版
     * @param integer $template_id 要删除的模版ID
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function deleteTemplate($template_id)
    {
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/wxa/deletetemplate?access_token={$component_access_token}";
        return $this->httpPostForJson($url, ['template_id' => $template_id]);
    }
    
}
