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

use app\wechat\service\FansService;
use think\Exception;

/**
 * 微信数据服务
 * Class WechatService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/22 15:32
 *
 * @method \WeChat\Card card() static 卡券管理
 * @method \WeChat\Custom custom() static 客服消息处理
 * @method \WeChat\Limit limit() static 接口调用频次限制
 * @method \WeChat\Media media() static 微信素材管理
 * @method \WeChat\Menu menu() static 微信素材管理
 * @method \WeChat\Oauth oauth() static 微信网页授权
 * @method \WeChat\Pay pay() static 微信支付商户
 * @method \WeChat\Product product() static 商店管理
 * @method \WeChat\Qrcode qrcode() static 二维码管理
 * @method \WeChat\Receive receive() static 公众号推送管理
 * @method \WeChat\Scan scan() static 扫一扫接入管理
 * @method \WeChat\Script script() static 微信前端支持
 * @method \WeChat\Shake shake() static 揺一揺周边
 * @method \WeChat\Tags tags() static 用户标签管理
 * @method \WeChat\Template template() static 模板消息
 * @method \WeChat\User user() static 微信粉丝管理
 * @method \WeChat\Wifi wifi() static 门店WIFI管理
 * @method void wechat() static 第三方微信工具
 * @method void config() static 第三方配置工具
 */
class WechatService
{

    /**
     * 获取微信实例ID
     * @param string $name 实例对象名称
     * @return SoapService|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function instance($name)
    {
        switch (strtolower(sysconf('wechat_type'))) {
            case 'api':
                $config = [
                    'token'          => sysconf('wechat_token'),
                    'appid'          => sysconf('wechat_appid'),
                    'appsecret'      => sysconf('wechat_appsecret'),
                    'encodingaeskey' => sysconf('wechat_encodingaeskey'),
                    'mch_id'         => sysconf('wechat_mch_id'),
                    'mch_key'        => sysconf('wechat_partnerkey'),
                    'ssl_cer'        => sysconf('wechat_cert_cert'),
                    'ssl_key'        => sysconf('wechat_cert_key'),
                    'cachepath'      => env('cache_path') . 'wechat' . DIRECTORY_SEPARATOR,
                ];
                $class = '\\WeChat\\' . ucfirst(strtolower($name));
                if (class_exists($class)) {
                    return new $class($config);
                }
                throw new Exception("Class '{$class}' not found");
            case 'thr':
            default:
                list($appid, $appkey) = [sysconf('wechat_thr_appid'), sysconf('wechat_thr_appkey')];
                $token = strtolower("{$name}-{$appid}-{$appkey}");
                $location = config('wechat.service_url') . "/wechat/api.client/soap/{$token}.html";
                $params = ['uri' => strtolower($name), 'location' => $location, 'trace' => true];
                return new SoapService(null, $params);
        }
    }

    /**
     * 获取微信网页JSSDK
     * @param null|string $url JS签名地址
     * @return array
     * @throws Exception
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\exception\PDOException
     */
    public static function webJsSDK($url = null)
    {
        switch (strtolower(sysconf('wechat_type'))) {
            case 'api':
                return WechatService::script()->getJsSign(is_null($url) ? app('request')->url(true) : $url);
            case 'thr':
            default:
                return WechatService::wechat()->jsSign(is_null($url) ? app('request')->url(true) : $url);
        }
    }

    /**
     * 初始化进入授权
     * @param string $url 授权页面URL地址
     * @param int $fullMode 授权公众号模式
     * @param bool $isRedirect 是否进行跳转
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function webOauth($url, $fullMode = 0, $isRedirect = true)
    {
        $appid = self::getAppid();
        list($openid, $fansinfo) = [session("{$appid}_openid"), session("{$appid}_fansinfo")];
        if ((empty($fullMode) && !empty($openid)) || (!empty($fullMode) && !empty($fansinfo))) {
            empty($fansinfo) || FansService::set($fansinfo);
            return ['openid' => $openid, 'fansinfo' => $fansinfo];
        }
        switch (strtolower(sysconf('wechat_type'))) {
            case 'api':
                $wechat = self::oauth();
                if (request()->get('state') !== $appid) {
                    $snsapi = empty($fullMode) ? 'snsapi_base' : 'snsapi_userinfo';
                    $param = (strpos($url, '?') !== false ? '&' : '?') . 'rcode=' . encode($url);
                    $OauthUrl = $wechat->getOauthRedirect($url . $param, $appid, $snsapi);
                    $isRedirect && redirect($OauthUrl, [], 301)->send();
                    exit("window.location.href='{$OauthUrl}'");
                }
                $token = $wechat->getOauthAccessToken();
                if (isset($token['openid'])) {
                    session("{$appid}_openid", $openid = $token['openid']);
                    if (empty($fullMode) && request()->get('rcode')) {
                        redirect(decode(request()->get('rcode')))->send();
                    }
                    session("{$appid}_fansinfo", $fansinfo = $wechat->getUserInfo($token['access_token'], $openid));
                    empty($fansinfo) || FansService::set($fansinfo);
                }
                redirect(decode(request()->get('rcode')))->send();
                break;
            case 'thr':
            default:
                $service = self::wechat();
                $result = $service->oauth(session_id(), $url, $fullMode);
                session("{$appid}_openid", $openid = $result['openid']);
                session("{$appid}_fansinfo", $fansinfo = $result['fans']);
                if ((empty($fullMode) && !empty($openid)) || (!empty($fullMode) && !empty($fansinfo))) {
                    empty($fansinfo) || FansService::set($fansinfo);
                    return ['openid' => $openid, 'fansinfo' => $fansinfo];
                }
                if ($isRedirect && !empty($result['url'])) {
                    redirect($result['url'], [], 301)->send();
                }
                exit("window.location.href='{$result['url']}'");
        }
    }

    /**
     * 获取当前公众号的AppId
     * @return bool|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getAppid()
    {
        switch (strtolower(sysconf('wechat_type'))) {
            case 'api':
                return sysconf('wechat_appid');
            case 'thr':
                return sysconf('wechat_thr_appid');
            default:
                return '';
        }
    }

    /**
     * 魔术静态方法实现对象
     * @param string $name
     * @param array $arguments
     * @return SoapService
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function __callStatic($name, $arguments)
    {
        return self::instance($name);
    }

}
