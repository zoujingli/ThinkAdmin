<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\service;

use think\admin\extend\JsonRpcClient;
use think\admin\Service;
use think\admin\storage\LocalStorage;
use think\exception\HttpResponseException;

/**
 * Class WechatService
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
     * @throws \think\Exception
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        [$type, $class, $classname] = static::parseName($name);
        if ("{$type}{$class}" !== $name) {
            throw new \think\Exception("抱歉，实例 {$name} 不在符合规则！");
        }
        if (sysconf('wechat.type') === 'api' || $type === 'WePay') {
            if ($type === 'ThinkService') {
                throw new \think\Exception("抱歉，接口模式不能实例 {$classname} 对象！");
            }
            return new $classname(static::instance()->getConfig());
        } else {
            [$appid, $appkey] = [sysconf('wechat.thr_appid'), sysconf('wechat.thr_appkey')];
            $data = ['class' => $name, 'appid' => $appid, 'time' => time(), 'nostr' => uniqid()];
            $data['sign'] = md5("{$data['class']}#{$appid}#{$appkey}#{$data['time']}#{$data['nostr']}");
            $token = enbase64url(json_encode($data, JSON_UNESCAPED_UNICODE));
            $location = "https://open.cuci.cc/service/api.client/_TYPE_?not_init_session=1&token={$token}";
            if (class_exists('Yar_Client')) {
                $client = new \Yar_Client(str_replace('_TYPE_', 'yar', $location));
            } else {
                $client = new JsonRpcClient(str_replace('_TYPE_', 'jsonrpc', $location));
            }
            try {
                $exception = new \think\Exception($client->getMessage(), $client->getCode());
            } catch (\Exception  $exception) {
                $exception = null;
            }
            if ($exception instanceof \Exception) {
                throw $exception;
            }
            return $client;
        }
    }

    /**
     * 解析调用对象名称
     * @param string $name
     * @return array
     */
    private static function parseName(string $name): array
    {
        foreach (['WeChat', 'WeMini', 'WeOpen', 'WePay', 'ThinkService'] as $type) {
            if (strpos($name, $type) === 0) {
                [, $class] = explode($type, $name);
                return [$type, $class, "\\{$type}\\{$class}"];
            }
        }
        return ['-', '-', $name];
    }

    /**
     * 获取当前微信APPID
     * @return string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAppid(): string
    {
        if ($this->getType() === 'api') {
            return sysconf('wechat.appid');
        } else {
            return sysconf('wechat.thr_appid');
        }
    }

    /**
     * 获取接口授权模式
     * @return string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getType(): string
    {
        $type = strtolower(sysconf('wechat.type'));
        if (in_array($type, ['api', 'thr'])) return $type;
        throw new \think\Exception('请在后台配置微信对接授权模式');
    }

    /**
     * 获取公众号配置参数
     * @return array
     * @throws \think\Exception
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getConfig(): array
    {
        $options = [
            'appid'          => $this->getAppid(),
            'token'          => sysconf('wechat.token'),
            'appsecret'      => sysconf('wechat.appsecret'),
            'encodingaeskey' => sysconf('wechat.encodingaeskey'),
            'mch_id'         => sysconf('wechat.mch_id'),
            'mch_key'        => sysconf('wechat.mch_key'),
            'cache_path'     => $this->app->getRuntimePath() . 'wechat',
        ];
        $local = LocalStorage::instance();
        switch (strtolower(sysconf('wechat.mch_ssl_type'))) {
            case 'p12':
                $options['ssl_p12'] = $local->path(sysconf('wechat.mch_ssl_p12'), true);
                break;
            case 'pem':
                $options['ssl_key'] = $local->path(sysconf('wechat.mch_ssl_key'), true);
                $options['ssl_cer'] = $local->path(sysconf('wechat.mch_ssl_cer'), true);
                break;
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
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getWebOauthInfo(string $source, $isfull = 0, $redirect = true): array
    {
        $appid = $this->getAppid();
        $openid = $this->app->session->get("{$appid}_openid");
        $userinfo = $this->app->session->get("{$appid}_fansinfo");
        if ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($userinfo))) {
            empty($userinfo) || FansService::instance()->set($userinfo, $appid);
            return ['openid' => $openid, 'fansinfo' => $userinfo];
        }
        if ($this->getType() === 'api') {
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
                $this->app->session->set("{$appid}_openid", $openid = $token['openid']);
                if ($isfull && isset($token['access_token'])) {
                    $userinfo = $wechat->getUserInfo($token['access_token'], $openid);
                    $this->app->session->set("{$appid}_fansinfo", $userinfo);
                    empty($userinfo) || FansService::instance()->set($userinfo, $appid);
                }
            }
            if ($getVars['rcode']) {
                $location = debase64url($getVars['rcode']);
                throw new HttpResponseException($redirect ? redirect($location, 301) : response("location.href='{$location}'"));
            } elseif ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($userinfo))) {
                return ['openid' => $openid, 'fansinfo' => $userinfo];
            } else {
                throw new \think\Exception('Query params [rcode] not find.');
            }
        } else {
            $result = static::ThinkServiceConfig()->oauth($this->app->session->getId(), $source, $isfull);
            $this->app->session->set("{$appid}_openid", $openid = $result['openid']);
            $this->app->session->set("{$appid}_fansinfo", $userinfo = $result['fans']);
            if ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($userinfo))) {
                empty($userinfo) || FansService::instance()->set($userinfo, $appid);
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
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getWebJssdkSign(?string $location = null): array
    {
        $location = $location ?: $this->app->request->url(true);
        if ($this->getType() === 'api') {
            return static::WeChatScript()->getJsSign($location);
        } else {
            return static::ThinkServiceConfig()->jsSign($location);
        }
    }
}