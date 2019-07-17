<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\service;

/**
 * 微信处理管理
 * Class WechatService
 * @package app\wechat\service
 *
 * ----- WeOpen for Open -----
 * @method \WeOpen\Login login() static 第三方微信登录
 * @method \WeOpen\Service service() static 第三方服务
 *
 * ----- WeMini for Open -----
 * @method \WeMini\Code WeMiniCode() static 小程序代码管理
 * @method \WeMini\User WeMiniUser() static 小程序帐号管理
 * @method \WeMini\Basic WeMiniBasic() static 小程序基础信息
 * @method \WeMini\Domain WeMiniDomain() static 小程序域名管理
 * @method \WeMini\Tester WeMiniTester() static 小程序成员管理
 * @method \WeMini\Account WeMiniAccount() static 小程序账号管理
 *
 * ----- ThinkService -----
 * @method mixed wechat() static 第三方微信工具
 */
class WechatService extends \We
{

    /**
     * 获取微信支付配置
     * @param array|null $options
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function config($options = null)
    {
        if (empty($options)) $options = [
            // 微信功能必需参数
            'appid'          => self::getAppid(),
            'token'          => sysconf('wechat_token'),
            'appsecret'      => sysconf('wechat_appsecret'),
            'encodingaeskey' => sysconf('wechat_encodingaeskey'),
            // 微信支付必要参数
            'mch_id'         => sysconf('wechat_mch_id'),
            'mch_key'        => sysconf('wechat_mch_key'),
            'cache_path'     => env('runtime_path') . 'wechat' . DIRECTORY_SEPARATOR,
        ];
        if (sysconf('wechat_mch_ssl_type') === 'p12') {
            $options['ssl_p12'] = self::_parseCertPath(sysconf('wechat_mch_ssl_p12'));
        } else {
            $options['ssl_key'] = self::_parseCertPath(sysconf('wechat_mch_ssl_key'));
            $options['ssl_cer'] = self::_parseCertPath(sysconf('wechat_mch_ssl_cer'));
        }
        return parent::config($options);
    }

    /**
     * 解析证书路径
     * @param string $path
     * @return mixed
     * @throws \think\Exception
     */
    private static function _parseCertPath($path)
    {
        if (preg_match('|^[a-z0-9]{16,16}\/[a-z0-9]{16,16}\.|i', $path)) {
            return \library\File::instance('local')->path($path, true);
        }
        return $path;
    }

    /**
     * 静态魔术加载方法
     * @param string $name 静态类名
     * @param array $arguments 参数集合
     * @return mixed
     * @throws \SoapFault
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function __callStatic($name, $arguments)
    {
        $config = [];
        if (is_array($arguments) && count($arguments) > 0) {
            $option = array_shift($arguments);
            $config = is_array($option) ? $option : self::config();
        }
        if (in_array($name, ['wechat'])) {
            return self::instance(trim($name, '_'), 'WeChat', $config);
        } elseif (substr($name, 0, 6) === 'WeChat') {
            return self::instance(substr($name, 6), 'WeChat', $config);
        } elseif (substr($name, 0, 6) === 'WeMini') {
            return self::instance(substr($name, 6), 'WeMini', $config);
        } elseif (substr($name, 0, 5) === 'WePay') {
            return self::instance(substr($name, 5), 'WePay', $config);
        } elseif (substr($name, 0, 6) === 'AliPay') {
            return self::instance(substr($name, 6), 'AliPay', $config);
        } else {
            throw new \think\Exception("class {$name} not found");
        }
    }

    /**
     * 接口对象实例化
     * @param string $name 接口名称
     * @param string $type 接口类型
     * @param array $config 微信配置
     * @return mixed
     * @throws \SoapFault
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function instance($name, $type = 'WeChat', $config = [])
    {
        if (self::getType() === 'api' || in_array($type, ['WePay', 'AliPay']) || "{$type}{$name}" === 'WeChatPay') {
            if (class_exists($class = "\\{$type}\\" . ucfirst(strtolower($name)))) {
                return new $class(empty($config) ? self::config() : $config);
            } else {
                throw new \think\Exception("Class {$class} not found");
            }
        } else {
            set_time_limit(3600);
            list($appid, $appkey) = [sysconf('wechat_thr_appid'), sysconf('wechat_thr_appkey')];
            $token = strtolower("{$name}-{$appid}-{$appkey}-{$type}");
            if (class_exists('Yar_Client')) {
                return new \Yar_Client(config('wechat.service_url') . "/service/api.client/yar/{$token}");
            } elseif (class_exists('SoapClient')) {
                $location = config('wechat.service_url') . "/service/api.client/soap/{$token}";
                return new \SoapClient(null, ['uri' => strtolower($name), 'location' => $location]);
            } else {
                throw new \think\Exception("Yar or Soap extensions are not installed.");
            }
        }
    }

    /**
     * 获取微信网页JSSDK
     * @param string $url JS签名地址
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getWebJssdkSign($url = null)
    {
        $url = is_null($url) ? request()->url(true) : $url;
        if (self::getType() === 'api') {
            return self::WeChatScript()->getJsSign($url);
        } else {
            return self::wechat()->jsSign($url);
        }
    }

    /**
     * 初始化进入授权
     * @param string $url 授权页面URL地址
     * @param integer $isfull 授权微信模式
     * @param boolean $isRedirect 是否进行跳转
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getWebOauthInfo($url, $isfull = 0, $isRedirect = true)
    {
        $appid = self::getAppid();
        list($openid, $fansinfo) = [session("{$appid}_openid"), session("{$appid}_fansinfo")];
        if ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($fansinfo))) {
            empty($fansinfo) || FansService::set($fansinfo);
            return ['openid' => $openid, 'fansinfo' => $fansinfo];
        }
        if (self::getType() === 'api') {
            $wechat = self::WeChatOauth();
            if (request()->get('state') !== $appid) {
                $snsapi = empty($isfull) ? 'snsapi_base' : 'snsapi_userinfo';
                $param = (strpos($url, '?') !== false ? '&' : '?') . 'rcode=' . encode($url);
                $OauthUrl = $wechat->getOauthRedirect($url . $param, $appid, $snsapi);
                if ($isRedirect) redirect($OauthUrl, [], 301)->send();
                exit("window.location.href='{$OauthUrl}'");
            }
            if (($token = $wechat->getOauthAccessToken()) && isset($token['openid'])) {
                session("{$appid}_openid", $openid = $token['openid']);
                if (empty($isfull) && request()->get('rcode')) {
                    redirect(decode(request()->get('rcode')), [], 301)->send();
                }
                session("{$appid}_fansinfo", $fansinfo = $wechat->getUserInfo($token['access_token'], $openid));
                empty($fansinfo) || FansService::set($fansinfo);
            }
            redirect(decode(request()->get('rcode')), [], 301)->send();
        } else {
            $result = self::wechat()->oauth(session_id(), $url, $isfull);
            session("{$appid}_openid", $openid = $result['openid']);
            session("{$appid}_fansinfo", $fansinfo = $result['fans']);
            if ((empty($isfull) && !empty($openid)) || (!empty($isfull) && !empty($openid) && !empty($fansinfo))) {
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
     * 获取当前微信APPID
     * @return bool|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getAppid()
    {
        if (self::getType() === 'api') {
            return sysconf('wechat_appid');
        } else {
            return sysconf('wechat_thr_appid');
        }
    }

    /**
     * 获取接口授权模式
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getType()
    {
        $type = strtolower(sysconf('wechat_type'));
        if (in_array($type, ['api', 'thr'])) return $type;
        throw new \think\Exception('请在后台配置微信对接授权模式');
    }

}
