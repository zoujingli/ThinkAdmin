<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace app\wechat\service;

use think\admin\Exception;
use think\admin\extend\JsonRpcClient;
use think\admin\Library;
use think\admin\Service;
use think\admin\Storage;
use think\admin\storage\LocalStorage;
use think\exception\HttpResponseException;

/**
 * 微信接口调度服务
 * @class WechatService
 * @package app\wechat\serivce
 *
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
 * @method \WeMini\Tester WeMinitester() static 小程序成员管理
 * @method \WeMini\User WeMiniUser() static 小程序帐号管理
 * --------------------
 * @method \WeMini\Crypt WeMiniCrypt() static 小程序数据加密处理
 * @method \WeMini\Delivery WeMiniDelivery() static 小程序即时配送
 * @method \WeMini\Image WeMiniImage() static 小程序图像处理
 * @method \WeMini\Logistics WeMiniLogistics() static 小程序物流助手
 * @method \WeMini\Message WeMiniMessage() static 小程序动态消息
 * @method \WeMini\Ocr WeMiniOcr() static 小程序ORC服务
 * @method \WeMini\Plugs WeMiniPlugs() static 小程序插件管理
 * @method \WeMini\Poi WeMiniPoi() static 小程序地址管理
 * @method \WeMini\Qrcode WeMiniQrcode() static 小程序二维码管理
 * @method \WeMini\Security WeMiniSecurity() static 小程序内容安全
 * @method \WeMini\Soter WeMiniSoter() static 小程序生物认证
 * @method \WeMini\Template WeMiniTemplate() static 小程序模板消息支持
 * @method \WeMini\Total WeMiniTotal() static 小程序数据接口
 * @method \WeMini\Newtmpl WeMiniNewtmpl() static 小程序订阅消息支持
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
 * ----- WePayV3 -----
 * @method \WePayV3\Transfers WePayV3Transfers() static 微信商家转账到零钱
 * @method \WePayV3\ProfitSharing WePayV3ProfitSharing() static 微信商户分账
 *
 * ----- WeOpen -----
 * @method \WeOpen\Login WeOpenLogin() static 第三方微信登录
 * @method \WeOpen\Service WeOpenService() static 第三方服务
 *
 * ----- ThinkService -----
 * @method mixed ThinkServiceConfig() static 平台服务配置
 */
class WechatService extends Service
{

    /**
     * 静态初始化对象
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \think\admin\Exception
     */
    public static function __callStatic(string $name, array $arguments)
    {
        [$type, $base, $class] = static::parseName($name);
        if ("{$type}{$base}" !== $name) {
            throw new Exception("抱歉，实例 {$name} 不符合规则！");
        }
        if (sysconf('wechat.type') === 'api' || $type === 'WePay') {
            if (class_exists($class)) {
                return new $class(static::getConfig());
            } else {
                throw new Exception("抱歉，接口模式无法实例 {$class} 对象！");
            }
        } else {
            [$appid, $appkey] = [sysconf('wechat.thr_appid'), sysconf('wechat.thr_appkey')];
            $data = ['class' => $name, 'appid' => $appid, 'time' => time(), 'nostr' => uniqid()];
            $data['sign'] = md5("{$data['class']}#{$appid}#{$appkey}#{$data['time']}#{$data['nostr']}");
            // 创建远程连接，默认使用 JSON-RPC 方式调用接口
            $token = enbase64url(json_encode($data, JSON_UNESCAPED_UNICODE));
            $jsonrpc = sysconf('wechat.service_jsonrpc|raw') ?: 'https://open.cuci.cc/service/api.client/jsonrpc?not_init_session=1&token=TOKEN';
            return new JsonRpcClient(str_replace('token=TOKEN', "token={$token}", $jsonrpc));
        }
    }

    /**
     * 解析调用对象名称
     * @param string $name
     * @return array
     */
    private static function parseName(string $name): array
    {
        foreach (['WeChat', 'WeMini', 'WeOpen', 'WePayV3', 'WePay', 'ThinkService'] as $type) {
            if (strpos($name, $type) === 0) {
                [, $base] = explode($type, $name);
                return [$type, $base, "\\{$type}\\{$base}"];
            }
        }
        return ['-', '-', $name];
    }

    /**
     * 获取当前微信APPID
     * @return string
     * @throws \think\admin\Exception
     */
    public static function getAppid(): string
    {
        if (static::getType() === 'api') {
            return sysconf('wechat.appid');
        } else {
            return sysconf('wechat.thr_appid');
        }
    }

    /**
     * 获取接口授权模式
     * @return string
     * @throws \think\admin\Exception
     */
    public static function getType(): string
    {
        $type = strtolower(sysconf('wechat.type'));
        if (in_array($type, ['api', 'thr'])) return $type;
        throw new Exception('请在后台配置微信对接授权模式');
    }

    /**
     * 获取公众号配置参数
     * @return array
     * @throws \think\admin\Exception
     */
    public static function getConfig(): array
    {
        $options = [
            'appid'          => static::getAppid(),
            'token'          => sysconf('wechat.token'),
            'appsecret'      => sysconf('wechat.appsecret'),
            'encodingaeskey' => sysconf('wechat.encodingaeskey'),
            'mch_id'         => sysconf('wechat.mch_id'),
            'mch_key'        => sysconf('wechat.mch_key'),
            'mch_v3_key'     => sysconf('wechat.mch_v3_key'),
            'cache_path'     => syspath('runtime/wechat'),
        ];
        if (in_array($sslType = strtolower(sysconf('wechat.mch_ssl_type')), ['p12', 'pem'])) {
            [$local = LocalStorage::instance(), $options = static::withWxpayCert($options)];
            if ((empty($options['ssl_cer']) || empty($options['ssl_key'])) && $sslType === 'p12') {
                if (openssl_pkcs12_read($local->get(sysconf('wechat.mch_ssl_p12'), true), $certs, $options['mch_id'])) {
                    sysconf('wechat.mch_ssl_cer', $local->set(Storage::name($certs['pkey'], 'pem'), $certs['pkey'], true)['url']);
                    sysconf('wechat.mch_ssl_key', $local->set(Storage::name($certs['cert'], 'pem'), $certs['cert'], true)['url']);
                    static::withWxpayCert($options);
                } else {
                    throw new Exception('商户账号与 P12 证书不匹配！');
                }
            }
        }
        return $options;
    }

    /**
     * 处理支付证书配置
     * @param array $options
     * @return array
     * @throws \think\admin\Exception
     */
    private static function withWxpayCert(array &$options): array
    {
        // 文本模式主要是为了解决分布式部署
        $local = LocalStorage::instance();
        if (!empty($data = sysdata('plugin.wechat.payment.config'))) {
            if (empty($data['ssl_key_text']) || empty($data['ssl_cer_text'])) {
                throw new Exception('商户证书不能为空！');
            }
            $name1 = Storage::name($data['ssl_cer_text'], 'pem');
            $name2 = Storage::name($data['ssl_key_text'], 'pem');
            if ($local->has($name1, true) && $local->has($name2, true)) {
                $sslCer = $local->set($name1, $data['ssl_cer_text'], true)['file'];
                $sslKey = $local->set($name2, $data['ssl_key_text'], true)['file'];
            } else {
                $sslCer = $local->path($name1, true);
                $sslKey = $local->path($name2, true);
            }
            $options['ssl_cer'] = $sslCer;
            $options['ssl_key'] = $sslKey;
            $options['cert_public'] = $sslCer;
            $options['cert_private'] = $sslKey;
        } else {
            $sslCer = $local->path(sysconf('wechat.mch_ssl_cer'), true);
            $sslKey = $local->path(sysconf('wechat.mch_ssl_key'), true);
            if (is_file($sslCer)) $options['cert_public'] = $options['ssl_cer'] = $sslCer;
            if (is_file($sslKey)) $options['cert_private'] = $options['ssl_key'] = $sslKey;
        }
        return $options;
    }

    /**
     * 通过网页授权获取粉丝信息
     * @param string $source 回跳URL地址
     * @param integer $isfull 获取资料模式
     * @param boolean $redirect 是否直接跳转
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public static function getWebOauthInfo(string $source, int $isfull = 0, bool $redirect = true): array
    {
        $appid = static::getAppid();
        $openid = Library::$sapp->session->get("{$appid}_openid");
        $userinfo = Library::$sapp->session->get("{$appid}_fansinfo");
        if ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($userinfo))) {
            empty($userinfo) || FansService::set($userinfo, $appid);
            return ['openid' => $openid, 'fansinfo' => $userinfo];
        }
        if (static::getType() === 'api') {
            // 解析 GET 参数
            parse_str(parse_url($source, PHP_URL_QUERY), $params);
            $getVars = [
                'code'  => $params['code'] ?? input('code', ''),
                'rcode' => $params['rcode'] ?? input('rcode', ''),
                'state' => $params['state'] ?? input('state', ''),
            ];
            $wechat = static::WeChatOauth();
            if ($getVars['state'] !== $appid || empty($getVars['code'])) {
                $params['rcode'] = enbase64url($source);
                $location = strstr("{$source}?", '?', true) . '?' . http_build_query($params);
                $oauthurl = $wechat->getOauthRedirect($location, $appid, $isfull ? 'snsapi_userinfo' : 'snsapi_base');
                throw new HttpResponseException($redirect ? redirect($oauthurl, 301) : response("location.href='{$oauthurl}'"));
            } elseif (($token = $wechat->getOauthAccessToken($getVars['code'])) && isset($token['openid'])) {
                Library::$sapp->session->set("{$appid}_openid", $openid = $token['openid']);
                if ($isfull && isset($token['access_token'])) {
                    $userinfo = $wechat->getUserInfo($token['access_token'], $openid);
                    Library::$sapp->session->set("{$appid}_fansinfo", $userinfo);
                    empty($userinfo) || FansService::set($userinfo, $appid);
                }
            }
            if ($getVars['rcode']) {
                $location = debase64url($getVars['rcode']);
                throw new HttpResponseException($redirect ? redirect($location, 301) : response("location.href='{$location}'"));
            } elseif ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($userinfo))) {
                return ['openid' => $openid, 'fansinfo' => $userinfo];
            } else {
                throw new Exception('Query params [rcode] not find.');
            }
        } else {
            $result = static::ThinkServiceConfig()->oauth(Library::$sapp->session->getId(), $source, $isfull);
            Library::$sapp->session->set("{$appid}_openid", $openid = $result['openid']);
            Library::$sapp->session->set("{$appid}_fansinfo", $userinfo = $result['fans']);
            if ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($userinfo))) {
                empty($userinfo) || FansService::set($userinfo, $appid);
                return ['openid' => $openid, 'fansinfo' => $userinfo];
            }
            if ($redirect) {
                throw new HttpResponseException(redirect($result['url'], 301));
            } else {
                throw new HttpResponseException(response("location.href='{$result['url']}'"));
            }
        }
    }

    /**
     * 获取微信网页JSSDK签名参数
     * @param null|string $location 签名地址
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public static function getWebJssdkSign(?string $location = null): array
    {
        $location = $location ?: Library::$sapp->request->url(true);
        if (static::getType() === 'api') {
            return static::WeChatScript()->getJsSign($location);
        } else {
            return static::ThinkServiceConfig()->jsSign($location);
        }
    }
}
