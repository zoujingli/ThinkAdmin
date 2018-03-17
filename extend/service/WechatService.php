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
 * @method void wechat static 第三方微信工具
 * @method void config static 第三方配置工具
 */
class WechatService
{

    /**
     * 获取微信实例ID
     * @param string $name 实例对象名称
     * @return SoapService
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function instance($name)
    {
        list($appid, $appkey) = [sysconf('wechat_appid'), sysconf('wechat_appkey')];
        $token = strtolower("{$name}-{$appid}-{$appkey}");
        $location = config('wechat.service_url') . "/wechat/api.client/soap/param/{$token}.html";
        $params = ['uri' => strtolower($name), 'location' => $location, 'trace' => true];
        return new SoapService(null, $params);
    }

    /**
     * 初始化进入授权
     * @param int $fullMode 授权公众号模式
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function webOauth($fullMode = 0)
    {
        $appid = sysconf('wechat_appid');
        list($openid, $fansinfo) = [session("{$appid}_openid"), session("{$appid}_fansinfo")];
        if ((empty($fullMode) && !empty($openid)) || (!empty($fullMode) && !empty($fansinfo))) {
            empty($fansinfo) || FansService::set($fansinfo);
            return ['openid' => $openid, 'fansinfo' => $fansinfo];
        }
        $service = self::instance('wechat');
        $result = $service->oauth(session_id(), request()->url(true), $fullMode);
        session("{$appid}_openid", $openid = $result['openid']);
        session("{$appid}_fansinfo", $fansinfo = $result['fans']);
        if ((empty($fullMode) && !empty($openid)) || (!empty($fullMode) && !empty($fansinfo))) {
            empty($fansinfo) || FansService::set($fansinfo);
            return ['openid' => $openid, 'fansinfo' => $fansinfo];
        }
        if (!empty($result['url'])) {
            redirect($result['url'], [], 301)->send();
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
