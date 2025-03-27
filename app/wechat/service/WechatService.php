<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 Anyon <zoujingli@qq.com>
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
use think\admin\storage\LocalStorage;
use think\exception\HttpResponseException;
use think\Response;

/**
 * 微信接口调度服务
 * @class WechatService
 * @package app\wechat\serivce
 *
 * @method \WeChat\Card WeChatCard() static 微信卡券管理
 * @method \WeChat\Custom WeChatCustom() static 微信客服消息
 * @method \WeChat\Limit WeChatLimit() static 接口调用频次限制
 * @method \WeChat\Media WeChatMedia() static 微信素材管理
 * @method \WeChat\Draft WeChatDraft() static 微信草稿箱管理
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
 * @method \WeChat\Freepublish WeChatFreepublish() static 发布能力
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
 * @method \WeMini\Guide WeMiniGuide() static 小程序导购助手
 * @method \WeMini\Image WeMiniImage() static 小程序图像处理
 * @method \WeMini\Live WeMiniLive() static 小程序直播接口
 * @method \WeMini\Logistics WeMiniLogistics() static 小程序物流助手
 * @method \WeMini\Newtmpl WeMiniNewtmpl() static 公众号小程序订阅消息支持
 * @method \WeMini\Message WeMiniMessage() static 小程序动态消息
 * @method \WeMini\Operation WeMiniOperation() static 小程序运维中心
 * @method \WeMini\Ocr WeMiniOcr() static 小程序ORC服务
 * @method \WeMini\Plugs WeMiniPlugs() static 小程序插件管理
 * @method \WeMini\Poi WeMiniPoi() static 小程序地址管理
 * @method \WeMini\Qrcode WeMiniQrcode() static 小程序二维码管理
 * @method \WeMini\Security WeMiniSecurity() static 小程序内容安全
 * @method \WeMini\Soter WeMiniSoter() static 小程序生物认证
 * @method \WeMini\Template WeMiniTemplate() static 小程序模板消息支持
 * @method \WeMini\Total WeMiniTotal() static 小程序数据接口
 * @method \WeMini\Scheme WeMiniScheme() static 小程序URL-Scheme
 * @method \WeMini\Search WeMiniSearch() static 小程序搜索
 * @method \WeMini\Shipping WeMiniShipping() static 小程序发货信息管理服务
 *
 * ----- WePay -----
 * @method \WePay\Bill WePayBill() static 微信商户账单及评论
 * @method \WePay\Order WePayOrder() static 微信商户订单
 * @method \WePay\Refund WePayRefund() static 微信商户退款
 * @method \WePay\Coupon WePayCoupon() static 微信商户代金券
 * @method \WePay\Custom WePayCustom() static 微信扩展上报海关
 * @method \WePay\ProfitSharing WePayProfitSharing() static 微信分账
 * @method \WePay\Redpack WePayRedpack() static 微信红包支持
 * @method \WePay\Transfers WePayTransfers() static 微信商户打款到零钱
 * @method \WePay\TransfersBank WePayTransfersBank() static 微信商户打款到银行卡
 *
 * ----- WePayV3 -----
 * @method \WePayV3\Order WePayV3Order() static 直连商户|订单支付接口
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
        if (sysconf('wechat.type') === 'api' || in_array($type, ['WePay', 'WePayV3'])) {
            if (class_exists($class)) {
                return new $class($type === 'WeMini' ? static::getWxconf() : static::getConfig());
            } else {
                throw new Exception("抱歉，接口模式无法实例 {$class} 对象！");
            }
        } else {
            [$appid, $appkey] = [sysconf('wechat.thr_appid'), sysconf('wechat.thr_appkey')];
            $data = ['class' => $name, 'appid' => $appid, 'time' => time(), 'nostr' => uniqid()];
            $data['sign'] = md5("{$data['class']}#{$appid}#{$appkey}#{$data['time']}#{$data['nostr']}");
            // 创建远程连接，默认使用 JSON-RPC 方式调用接口
            $token = enbase64url(json_encode($data, JSON_UNESCAPED_UNICODE));
            $jsonrpc = sysconf('wechat.service_jsonrpc|raw') ?: 'https://open.cuci.cc/plugin-wechat-service/api.client/jsonrpc?token=TOKEN';
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
     * @param boolean $ispay 获取支付参数
     * @return array
     * @throws \think\admin\Exception
     */
    public static function getConfig(bool $ispay = false): array
    {
        $config = [
            'appid'          => static::getAppid(),
            'token'          => sysconf('wechat.token'),
            'appsecret'      => sysconf('wechat.appsecret'),
            'encodingaeskey' => sysconf('wechat.encodingaeskey'),
            'cache_path'     => syspath('runtime/wechat'),
        ];
        return $ispay ? static::withWxpayCert($config) : $config;
    }

    /**
     * 获取小程序配置参数
     * @param boolean $ispay 获取支付参数
     * @return array
     * @throws \think\admin\Exception
     */
    public static function getWxconf(bool $ispay = false): array
    {
        $wxapp = sysdata('plugin.wechat.wxapp');
        $config = [
            'appid'      => $wxapp['appid'] ?? '',
            'appsecret'  => $wxapp['appkey'] ?? '',
            'cache_path' => syspath('runtime/wechat'),
        ];
        return $ispay ? static::withWxpayCert($config) : $config;
    }

    /**
     * 处理支付证书配置
     * @param array $options
     * @return array
     * @throws \think\admin\Exception
     */
    public static function withWxpayCert(array $options): array
    {
        // 文本模式主要是为了解决分布式部署
        $data = sysdata('plugin.wechat.payment');
        if (empty($data['mch_id'])) {
            throw new Exception('无效的支付配置！');
        }
        $name1 = sprintf("wxpay/%s_%s_cer.pem", $data['mch_id'], md5($data['ssl_cer_text']));
        $name2 = sprintf("wxpay/%s_%s_key.pem", $data['mch_id'], md5($data['ssl_key_text']));
        $local = LocalStorage::instance();
        if ($local->has($name1, true) && $local->has($name2, true)) {
            $sslCer = $local->path($name1, true);
            $sslKey = $local->path($name2, true);
        } else {
            $sslCer = $local->set($name1, $data['ssl_cer_text'], true)['file'];
            $sslKey = $local->set($name2, $data['ssl_key_text'], true)['file'];
        }
        $options['mch_id'] = $data['mch_id'];
        $options['mch_key'] = $data['mch_key'];
        $options['mch_v3_key'] = $data['mch_v3_key'];
        $options['ssl_cer'] = $sslCer;
        $options['ssl_key'] = $sslKey;
        $options['cert_public'] = $sslCer;
        $options['cert_private'] = $sslKey;
        $options['mp_cert_serial'] = $data['mch_pay_sid'] ?? '';
        $options['mp_cert_content'] = $data['ssl_pay_text'] ?? '';
        return $options;
    }

    /**
     * 获取会话名称
     * @return string
     */
    public static function getSsid(): string
    {
        $conf = Library::$sapp->session->getConfig();
        $ssid = Library::$sapp->request->get($conf['name'] ?? 'ssid');
        return empty($ssid) ? Library::$sapp->session->getId() : $ssid;
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
        [$ssid, $appid] = [static::getSsid(), static::getAppid()];
        $openid = Library::$sapp->cache->get("{$ssid}_openid");
        $userinfo = Library::$sapp->cache->get("{$ssid}_fansinfo");
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
                throw new HttpResponseException(static::createRedirect($oauthurl, $redirect));
            } elseif (($token = $wechat->getOauthAccessToken($getVars['code'])) && isset($token['openid'])) {
                $openid = $token['openid'];
                // 如果是虚拟账号，不保存会话信息，下次重新授权
                if (empty($token['is_snapshotuser'])) {
                    Library::$sapp->cache->set("{$ssid}_openid", $openid, 3600);
                }
                if ($isfull && isset($token['access_token'])) {
                    $userinfo = $wechat->getUserInfo($token['access_token'], $openid);
                    // 如果是虚拟账号，不保存会话信息，下次重新授权
                    if (empty($token['is_snapshotuser'])) {
                        $userinfo['is_snapshotuser'] = 0;
                        // 缓存用户信息
                        Library::$sapp->cache->set("{$ssid}_fansinfo", $userinfo, 3600);
                        empty($userinfo) || FansService::set($userinfo, $appid);
                    } else {
                        $userinfo['is_snapshotuser'] = 1;
                    }
                }
            }
            if ($getVars['rcode']) {
                throw new HttpResponseException(static::createRedirect(debase64url($getVars['rcode']), $redirect));
            } elseif ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($userinfo))) {
                return ['openid' => $openid, 'fansinfo' => $userinfo];
            } else {
                throw new Exception('Query params [rcode] not find.');
            }
        } else {
            $result = static::ThinkServiceConfig()->oauth(self::getSsid(), $source, $isfull);
            [$openid, $userinfo] = [$result['openid'] ?? '', $result['fans'] ?? []];
            // 如果是虚拟账号，不保存会话信息，下次重新授权
            if (empty($result['token']['is_snapshotuser'])) {
                Library::$sapp->cache->set("{$ssid}_openid", $openid, 3600);
                Library::$sapp->cache->set("{$ssid}_fansinfo", $userinfo, 3600);
            }
            if ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($userinfo))) {
                empty($result['token']['is_snapshotuser']) && empty($userinfo) || FansService::set($userinfo, $appid);
                return ['openid' => $openid, 'fansinfo' => $userinfo];
            }
            throw new HttpResponseException(static::createRedirect($result['url'], $redirect));
        }
    }

    /**
     * 网页授权链接跳转
     * @param string $location 跳转链接
     * @param boolean $redirect 强制跳转
     * @return \think\Response
     */
    private static function createRedirect(string $location, bool $redirect = true): Response
    {
        return $redirect ? redirect($location) : response(join(";\n", [
            sprintf("sessionStorage.setItem('wechat.session','%s')", self::getSsid()),
            sprintf("location.replace('%s')", $location), ''
        ]));
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
