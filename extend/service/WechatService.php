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
 * ----- WeChat -----
 * @method \WeChat\Card WeChatCard() static 微信卡券管理
 * @method \WeChat\Custom WeChatCustom() static 微信客服消息
 * @method \WeChat\Limit WeChatLimit() static 接口调用频次限制
 * @method \WeChat\Media WeChatMedia() static 微信素材管理
 * @method \WeChat\Menu WeChatMenu() static 微信菜单管理
 * @method \WeChat\Oauth WeChatOauth() static 微信网页授权
 * @method \WeChat\Pay WeChatPay() static 微信支付商户
 * @method \WeChat\Product WeChatProduct() static 微信商店管理
 * @method \WeChat\Qrcode WeChatQrcode() static 微信二维码管理
 * @method \WeChat\Receive WeChatReceive() static 微信推送管理
 * @method \WeChat\Scan WeChatScan() static 微信扫一扫接入管理
 * @method \WeChat\Script WeChatScript() static 微信前端支持
 * @method \WeChat\Shake WeChatShake() static 微信揺一揺周边
 * @method \WeChat\Tags WeChatTags() static 微信用户标签管理
 * @method \WeChat\Template WeChatTemplate() static 微信模板消息
 * @method \WeChat\User WeChatUser() static 微信粉丝管理
 * @method \WeChat\Wifi WeChatWifi() static 微信门店WIFI管理
 *
 * ----- WeMini -----
 * @method \WeMini\Account WeMiniAccount() static 小程序账号管理
 * @method \WeMini\Basic WeMiniBasic() static 小程序基础信息设置
 * @method \WeMini\Code WeMiniCode() static 小程序代码管理
 * @method \WeMini\Domain WeMiniDomain() static 小程序域名管理
 * @method \WeMini\Tester WeMiniTester() static 小程序成员管理
 * @method \WeMini\User WeMiniUser() static 小程序帐号管理
 * --------------------
 * @method \WeMini\Crypt WeMiniCrypt() static 小程序数据加密处理
 * @method \WeMini\Plugs WeMiniPlugs() static 小程序插件管理
 * @method \WeMini\Poi WeMiniPoi() static 小程序地址管理
 * @method \WeMini\Qrcode WeMiniQrcode() static 小程序二维码管理
 * @method \WeMini\Template WeMiniTemplate() static 小程序模板消息支持
 * @method \WeMini\Total WeMiniTotal() static 小程序数据接口
 *
 * ----- WePay -----
 * @method \WePay\Bill WePayBill() static 微信商户账单及评论
 * @method \WePay\Order WePayOrder() static 微信商户订单
 * @method \WePay\Refund WePayRefund() static 微信商户退款
 * @method \WePay\Coupon WePayCoupon() static 微信商户代金券
 * @method \WePay\Redpack WePayRedpack() static 微信红包支持
 * @method \WePay\Transfers WePayTransfers() static 微信商户打款到零钱
 * @method \WePay\TransfersBank WePayTransfersBank() static 微信商户打款到银行卡
 *
 * ----- WeOpen -----
 * @method \WeOpen\Login login() static 第三方微信登录
 * @method \WeOpen\Service service() static 第三方服务
 *
 * ----- ThinkService -----
 * @method mixed wechat() static 第三方微信工具
 * @method mixed config() static 第三方配置工具
 */
class WechatService
{

    /**
     * 接口类型模式
     * @var string
     */
    private static $type = 'WeChat';

    /**
     * 获取微信实例ID
     * @param string $name 实例对象名称
     * @param string $type 接口实例类型
     * @return SoapService|string
     * @throws Exception
     * @throws \think\exception\PDOException
     */
    public static function instance($name, $type = null)
    {
        if (!in_array($type, ['WeChat', 'WeMini'])) {
            $type = self::$type;
        }
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
                $class = "\\{$type}\\" . ucfirst(strtolower($name));
                if (class_exists($class)) {
                    return new $class($config);
                }
                throw new Exception("Class '{$class}' not found");
            case 'thr':
                list($appid, $appkey) = [sysconf('wechat_thr_appid'), sysconf('wechat_thr_appkey')];
                $token = strtolower("{$name}-{$appid}-{$appkey}-{$type}");
                $location = config('wechat.service_url') . "/wechat/api.client/soap/{$token}.html";
                $params = ['uri' => strtolower($name), 'location' => $location, 'trace' => true];
                return new SoapService(null, $params);
            default:
                throw new Exception('请在后台配置微信对接授权模式！');
        }
    }

    /**
     * 获取微信网页JSSDK
     * @param null|string $url JS签名地址
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function webJsSDK($url = null)
    {
        $signUrl = is_null($url) ? app('request')->url(true) : $url;
        switch (strtolower(sysconf('wechat_type'))) {
            case 'api':
                return WechatService::WeChatScript()->getJsSign($signUrl);
            case 'thr':
                return WechatService::wechat()->jsSign($signUrl);
            default:
                throw new Exception('请在后台配置微信对接授权模式！');
        }
    }

    /**
     * 初始化进入授权
     * @param string $url 授权页面URL地址
     * @param int $fullMode 授权公众号模式
     * @param bool $isRedirect 是否进行跳转
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
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
                $wechat = self::WeChatOauth();
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
                        redirect(decode(request()->get('rcode')), [], 301)->send();
                    }
                    session("{$appid}_fansinfo", $fansinfo = $wechat->getUserInfo($token['access_token'], $openid));
                    empty($fansinfo) || FansService::set($fansinfo);
                }
                redirect(decode(request()->get('rcode')), [], 301)->send();
                break;
            case 'thr':
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
            default:
                throw new Exception('请在后台配置微信对接授权模式！');

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
                throw new Exception('请在后台配置微信对接授权模式！');
        }
    }

    /**
     * 魔术静态方法实现对象
     * @param string $name 方法类名
     * @param array $arguments 调用参数
     * @return SoapService
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function __callStatic($name, $arguments)
    {
        if (substr($name, 0, 6) === 'WeMini') {
            self::$type = 'WeMini';
            $name = substr($name, 6);
        } elseif (substr($name, 0, 6) === 'WeChat') {
            self::$type = 'WeChat';
            $name = substr($name, 6);
        } elseif (substr($name, 0, 5) === 'WePay') {
            self::$type = 'WePay';
            $name = substr($name, 5);
        }
        return self::instance($name);
    }

}
