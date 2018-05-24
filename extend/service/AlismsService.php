<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace service;

/**
 * 阿里云短信服务
 * Class AlismsService
 * @package service
 *
 * @config 需要在config目录定义aliyun.php配置文件
 * @configParam aliyun.SmsAppid 阿里云短信APPID
 * @configParam aliyun.SmsAppkey 阿里云短信APPKEY
 */
class AlismsService
{

    /**
     * 短信SDK版本信息
     * @var array
     */
    private static $sdkVersion = [
        "RegionId" => "cn-hangzhou",
        "Version"  => "2017-05-25",
    ];

    /**
     * 短信发送记录查询
     * @param string $PhoneNumber 短信接收号码
     * @param string $SendDate 短信发送日期，格式Ymd，支持近30天记录查询
     * @param integer $PageSize 分页大小
     * @param integer $CurrentPage 当前页码
     * @param null|string $BizId 设置发送短信流水号(可选)
     * @return bool|array
     */
    public static function query($PhoneNumber, $SendDate, $PageSize = 10, $CurrentPage = 1, $BizId = null)
    {
        $params = [];
        $params["SendDate"] = $SendDate;
        $params["PageSize"] = $PageSize;
        $params["CurrentPage"] = $CurrentPage;
        $params["PhoneNumber"] = $PhoneNumber;
        $params['Action'] = 'QuerySendDetails';
        is_null($BizId) || $params["BizId"] = $BizId;
        return self::request("dysmsapi.aliyuncs.com", array_merge($params, self::$sdkVersion), true);
    }

    /**
     * 批量发送短信
     * @param array $PhoneNumbers 待发送手机号
     * @param string $TemplateCode 短信模板Code
     * @param array $SignNames 短信签名
     * @param array $TemplateParams 模板中的变量
     * @param array $SmsUpExtendCodes 上行短信扩展码
     * @return bool|array
     */
    public static function batchSend(array $PhoneNumbers, $TemplateCode, array $SignNames, array $TemplateParams, $SmsUpExtendCodes = [])
    {
        $params = [];
        $params["Action"] = 'SendBatchSms';
        $params["TemplateCode"] = $TemplateCode;
        !empty($SmsUpExtendCodes) && $params["SmsUpExtendCodeJson"] = json_encode($SmsUpExtendCodes);
        $params["TemplateParamJson"] = json_encode($TemplateParams, JSON_UNESCAPED_UNICODE);
        $params["SignNameJson"] = json_encode($SignNames, JSON_UNESCAPED_UNICODE);
        $params["PhoneNumberJson"] = json_encode($PhoneNumbers, JSON_UNESCAPED_UNICODE);
        if (!empty($params["SmsUpExtendCodeJson"]) && is_array($params["SmsUpExtendCodeJson"])) {
            $params["SmsUpExtendCodeJson"] = json_encode($params["SmsUpExtendCodeJson"], JSON_UNESCAPED_UNICODE);
        }
        return self::request("dysmsapi.aliyuncs.com", array_merge($params, self::$sdkVersion), true);
    }

    /**
     * 发送短信
     * @param string $PhoneNumbers 短信接收号码
     * @param string $TemplateCode 短信模板Code
     * @param string $SignName 短信签名
     * @param array $TemplateParam 设置模板参数
     * @param null|string $OutId 设置发送短信流水号(可选)
     * @param null|string $SmsUpExtendCode 上行短信扩展码(可选)
     * @return bool|array
     */
    public static function send($PhoneNumbers, $TemplateCode, $SignName, array $TemplateParam, $OutId = null, $SmsUpExtendCode = null)
    {
        $params = [];
        $params['Action'] = 'SendSms';
        $params["SignName"] = $SignName;
        $params["TemplateCode"] = $TemplateCode;
        $params["PhoneNumbers"] = $PhoneNumbers;
        $params['TemplateParam'] = $TemplateParam;
        is_null($OutId) || $params['OutId'] = $OutId;
        is_null($SmsUpExtendCode) || $params['SmsUpExtendCode'] = $SmsUpExtendCode;
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        return self::request("dysmsapi.aliyuncs.com", array_merge($params, self::$sdkVersion), true);
    }

    /**
     * 生成签名并发起请求
     * @param $domain string API接口所在域名
     * @param $params array API具体参数
     * @param $security boolean 使用https
     * @return bool|array 返回API接口调用结果，当发生错误时返回false
     */
    public static function request($domain, $params, $security = false)
    {
        $apiParams = array_merge([
            "SignatureMethod"  => "HMAC-SHA1",
            "SignatureNonce"   => uniqid(mt_rand(0, 0xffff), true),
            "SignatureVersion" => "1.0",
            "AccessKeyId"      => config('aliyun.SmsAppid'),
            "Timestamp"        => gmdate("Y-m-d\TH:i:s\Z"),
            "Format"           => "JSON",
        ], $params);
        ksort($apiParams);
        $sortedQueryStringTmp = "";
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . self::encode($key) . "=" . self::encode($value);
        }
        $stringToSign = "GET&%2F&" . self::encode(substr($sortedQueryStringTmp, 1));
        $sign = base64_encode(hash_hmac("sha1", $stringToSign, config('aliyun.SmsAppkey') . "&", true));
        $signature = self::encode($sign);
        $url = ($security ? 'https' : 'http') . "://{$domain}/?Signature={$signature}{$sortedQueryStringTmp}";
        try {
            return json_decode(self::fetchContent($url), true);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 数据编码处理
     * @param string $str
     * @return null|string
     */
    private static function encode($str)
    {
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    /**
     * 网络请求
     * @param string $url 请求URL
     * @return mixed
     */
    private static function fetchContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["x-sdk-client" => "php/2.0.0"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $rtn = curl_exec($ch);
        if ($rtn === false) {
            trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        }
        curl_close($ch);
        return $rtn;
    }
}