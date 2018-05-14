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
use WeChat\Contracts\Tools;

/**
 * 代码管理
 * Class Tester
 * @package WeOpen\MiniApp
 */
class Code extends BasicWeChat
{

    /**
     * 1. 为授权的小程序帐号上传小程序代码
     * @param string $templateId 代码库中的代码模版ID
     * @param string $extJson 第三方自定义的配置
     * @param string $userVersion 代码版本号，开发者可自定义
     * @param string $userDesc 代码描述，开发者可自定义
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function commit($templateId, $extJson, $userVersion, $userDesc)
    {
        $url = 'https://api.weixin.qq.com/wxa/commit?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        $data = [
            'template_id'  => $templateId,
            'ext_json'     => $extJson,
            'user_version' => $userVersion,
            'user_desc'    => $userDesc,
        ];
        return $this->httpPostForJson($url, $data, true);
    }

    /**
     * 2. 获取体验小程序的体验二维码
     * @param null|string $path 指定体验版二维码跳转到某个具体页面
     * @param null|string $outType 指定输出类型
     * @return array|bool|string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getQrcode($path = null, $outType = null)
    {
        $pathStr = is_null($path) ? '' : ("&path=" . urlencode($path));
        $url = "https://api.weixin.qq.com/wxa/get_qrcode?access_token=ACCESS_TOKEN{$pathStr}";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        $result = Tools::get($url);
        if (json_decode($result)) {
            return Tools::json2arr($result);
        }
        return is_null($outType) ? $result : $outType($result);
    }

    /**
     * 3. 获取授权小程序帐号的可选类目
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getCategory()
    {
        $url = 'https://api.weixin.qq.com/wxa/get_category?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 4. 获取小程序的第三方提交代码的页面配置（仅供第三方开发者代小程序调用）
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getPage()
    {
        $url = 'https://api.weixin.qq.com/wxa/get_page?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 5. 将第三方提交的代码包提交审核（仅供第三方开发者代小程序调用）
     * @param array $itemList 提交审核项的一个列表
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function submitAudit(array $itemList)
    {
        $url = 'https://api.weixin.qq.com/wxa/submit_audit?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['item_list' => $itemList], true);
    }

    /**
     * 6. 获取审核结果
     * @return array
     */
    public function getNotify()
    {
        return Tools::xml2arr(file_get_contents('php://input'));
    }

    /**
     * 7. 查询某个指定版本的审核状态（仅供第三方代小程序调用）
     * @param string $auditid 提交审核时获得的审核id
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getAuditstatus($auditid)
    {
        $url = 'https://api.weixin.qq.com/wxa/get_auditstatus?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['auditid' => $auditid], true);
    }

    /**
     * 8、查询最新一次提交的审核状态（仅供第三方代小程序调用）
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getLatestAuditatus()
    {
        $url = 'https://api.weixin.qq.com/wxa/get_latest_auditstatus?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 9、发布已通过审核的小程序（仅供第三方代小程序调用）
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function publishRelease()
    {
        $url = 'https://api.weixin.qq.com/wxa/release?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, [], true);
    }

    /**
     * 10、修改小程序线上代码的可见状态（仅供第三方代小程序调用）
     * @param string $action 设置可访问状态，发布后默认可访问，close为不可见，open为可见
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function changeVisitStatus($action)
    {
        $url = 'https://api.weixin.qq.com/wxa/change_visitstatus?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['action' => $action], true);
    }

    /**
     * 11. 小程序版本回退（仅供第三方代小程序调用）
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function revertCodeRelease()
    {
        $url = 'https://api.weixin.qq.com/wxa/revertcoderelease?access_token=TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 12. 查询当前设置的最低基础库版本及各版本用户占比 （仅供第三方代小程序调用）
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getWeappSupportVersion()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/getweappsupportversion?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, []);
    }

    /**
     * 13. 设置最低基础库版本（仅供第三方代小程序调用）
     * @param string $version 版本
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function setWeappSupportVersion($version)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/setweappsupportversion?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['version' => $version]);
    }

    /**
     * 14. 设置小程序“扫普通链接二维码打开小程序”能力
     * (1) 增加或修改二维码规则
     * @param array $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function addQrcodeJump(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpadd?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }

    /**
     * 14. 设置小程序“扫普通链接二维码打开小程序”能力
     * (2) 获取已设置的二维码规则
     * @param array $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getQrcodeJump(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpget?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }

    /**
     * 14. 设置小程序“扫普通链接二维码打开小程序”能力
     * (3)获取校验文件名称及内容
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function downloadQrcodeJump()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpdownload?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, []);
    }

    /**
     * 14. 设置小程序“扫普通链接二维码打开小程序”能力
     * (4)删除已设置的二维码规则
     * @param string $prefix 二维码规则
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function deleteQrcodeJump($prefix)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpdelete?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['prefix' => $prefix]);
    }

    /**
     * 14. 设置小程序“扫普通链接二维码打开小程序”能力
     * (5)发布已设置的二维码规则
     * @param string $prefix 二维码规则
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function publishQrcodeJump($prefix)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumppublish?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['prefix' => $prefix]);
    }

    /**
     * 16. 小程序审核撤回
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function undoCodeAudit()
    {
        $url = 'https://api.weixin.qq.com/wxa/undocodeaudit?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 17.小程序分阶段发布
     * (1)分阶段发布接口
     * @param integer $gray_percentage 灰度的百分比，1到100的整数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function grayRelease($gray_percentage)
    {
        $url = 'https://api.weixin.qq.com/wxa/grayrelease?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['gray_percentage' => $gray_percentage]);
    }

    /**
     * 17.小程序分阶段发布
     * (2)取消分阶段发布
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function revertGrayRelease()
    {
        $url = 'https://api.weixin.qq.com/wxa/revertgrayrelease?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 17.小程序分阶段发布
     * (3)查询当前分阶段发布详情
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function getGrayreLeasePlan()
    {
        $url = 'https://api.weixin.qq.com/wxa/getgrayreleaseplan?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

}