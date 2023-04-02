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

use think\admin\Library;

/**
 * 微信扫码登录服务
 * @class LoginService
 * @package app\wechat\service
 */
class LoginService
{
    private const expire = 3600;
    private const prefix = 'wxlogin';

    /**
     * 生成请求编号
     * @return string
     */
    public static function gcode(): string
    {
        return md5(uniqid(strval(rand(0, 10000)), true));
    }

    /**
     * 生成授权码
     * @param string $code 请求编号
     * @return string
     */
    public static function gauth(string $code): string
    {
        return self::prefix . md5($code);
    }

    /**
     * 生成授权二维码
     * @param string $code 请求编号
     * @param integer $mode 授权模式
     * @param boolean|string $domain
     * @return array
     */
    public static function qrcode(string $code, int $mode = 0, $domain = true): array
    {
        $data = ['auth' => self::gauth($code), 'mode' => $mode];
        $image = MediaService::getQrcode(sysuri('wechat/api.login/oauth', $data, false, $domain));
        return ['code' => $code, 'auth' => $data['auth'], 'image' => $image->getDataUri()];
    }

    /**
     * 发起网页授权处理
     * @param string $auth 授权编号
     * @param integer $mode 授权模式
     * @return boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public static function oauth(string $auth = '', int $mode = 0): bool
    {
        if (stripos($auth, self::prefix) === 0) {
            $url = Library::$sapp->request->url(true);
            $fans = WechatService::getWebOauthInfo($url, $mode);
            if (isset($fans['openid'])) {
                Library::$sapp->cache->set($auth, $fans, self::expire);
                return true;
            }
        }
        return false;
    }

    /**
     * 检查是否授权
     * @param string $code 请求编号
     * @return ?array
     */
    public static function query(string $code): ?array
    {
        return Library::$sapp->cache->get(self::gauth($code));
    }

    /**
     * 删除授权缓存
     * @param string $code
     * @return bool
     */
    public static function remove(string $code): bool
    {
        return Library::$sapp->cache->delete(self::gauth($code));
    }
}