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
 * 微信小程序账号管理
 * Class Account
 * @package WeMini
 */
class Account extends BasicWeChat
{
    /**
     * 2.1 获取帐号基本信息
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getAccountBasicinfo()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/account/getaccountbasicinfo?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 2.2 小程序名称设置及改名
     * @param array $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function setNickname(array $data)
    {
        $url = 'https://api.weixin.qq.com/wxa/setnickname?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }

    /**
     * 2.3 小程序改名审核状态查询
     * @param integer $audit_id 审核单id
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function queryChangeNicknameAuditStatus($audit_id)
    {
        $url = "https://api.weixin.qq.com/wxa/api_wxa_querynickname?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['audit_id' => $audit_id]);
    }

    /**
     *
     * 2.4 微信认证名称检测
     * @param string $nickname 微信认证名称
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function checkWxVerifyNickname($nickname)
    {
        $url = "https://api.weixin.qq.com/wxa/api_wxa_querynickname?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['nick_name' => $nickname]);
    }

    /**
     * 2.5 修改头像
     * @param string $headImgMediaId 头像素材media_id
     * @param integer $x1 裁剪框左上角x坐标（取值范围：[0, 1]）
     * @param integer $y1 裁剪框左上角y坐标（取值范围：[0, 1]）
     * @param integer $x2 裁剪框右下角x坐标（取值范围：[0, 1]）
     * @param integer $y2 裁剪框右下角y坐标（取值范围：[0, 1]）
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function modifyHeadImage($headImgMediaId, $x1 = 0, $y1 = 0, $x2 = 1, $y2 = 1)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/account/modifyheadimage?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['head_img_media_id' => $headImgMediaId]);
    }

    /**
     * 2.6 修改功能介绍
     * @param string $signature 功能介绍（简介）
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException]
     */
    public function modifySignature($signature)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/account/modifysignature?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['signature' => $signature]);
    }

    /**
     * 2.7.3跳转至第三方平台，第三方平台调用快速注册API完成管理员换绑。
     * @param string $taskid 换绑管理员任务序列号(公众平台最终点击提交回跳到第三方平台时携带)
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function componentreBindAdmin($taskid)
    {
        $url = 'https://api.weixin.qq.com/cgi- bin/account/componentrebindadmin?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['taskid' => $taskid]);
    }

    /**
     * 3.1 获取账号可以设置的所有类目
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getAllCategories()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/getallcategories?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 3.2 添加类目
     * @param array $categories
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function addCategory($categories)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/addcategory?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['categories' => $categories]);
    }

    /**
     * 3.3 删除类目
     * @param string $first 一级类目ID
     * @param string $second 二级类目ID
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function delCategroy($first, $second)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/deletecategory?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['first' => $first, 'second' => $second]);
    }

    /**
     * 3.4 获取账号已经设置的所有类目
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getCategory()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/getcategory?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 3.5 修改类目
     * @param string $first 一级类目ID
     * @param string $second 二级类目ID
     * @param array $certicates
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function modifyCategory($first, $second, $certicates)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/modifycategory?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['first' => $first, 'second' => $second, 'categories' => $categories]);
    }
}