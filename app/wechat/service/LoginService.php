<?php

declare(strict_types=1);
/**
 * +----------------------------------------------------------------------
 * | ThinkAdmin Plugin for ThinkAdmin
 * +----------------------------------------------------------------------
 * | 版权所有 2014~2026 ThinkAdmin [ thinkadmin.top ]
 * +----------------------------------------------------------------------
 * | 官方网站: https://thinkadmin.top
 * +----------------------------------------------------------------------
 * | 开源协议 ( https://mit-license.org )
 * | 免责声明 ( https://thinkadmin.top/disclaimer )
 * | 会员特权 ( https://thinkadmin.top/vip-introduce )
 * +----------------------------------------------------------------------
 * | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
 * | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
 * +----------------------------------------------------------------------
 */

namespace app\wechat\service;

use think\admin\Exception;
use think\admin\Library;
use WeChat\Exceptions\InvalidResponseException;
use WeChat\Exceptions\LocalCacheException;

/**
 * 微信扫码登录服务
 * @class LoginService
 */
class LoginService
{
    private const expire = 3600;

    private const prefix = 'wxlogin';

    /**
     * 生成请求编号.
     */
    public static function gcode(): string
    {
        return md5(uniqid(strval(rand(0, 10000)), true));
    }

    /**
     * 生成授权码
     * @param string $code 请求编号
     */
    public static function gauth(string $code): string
    {
        return self::prefix . md5($code);
    }

    /**
     * 生成授权二维码
     * @param string $code 请求编号
     * @param int $mode 授权模式
     * @param bool|string $domain
     */
    public static function qrcode(string $code, int $mode = 0, $domain = true): array
    {
        $data = ['auth' => self::gauth($code), 'mode' => $mode];
        $image = MediaService::getQrcode(sysuri('wechat/api.login/oauth', $data, false, $domain));
        return ['code' => $code, 'auth' => $data['auth'], 'image' => $image->getDataUri()];
    }

    /**
     * 发起网页授权处理.
     * @param string $auth 授权编号
     * @param int $mode 授权模式
     * @throws InvalidResponseException
     * @throws LocalCacheException
     * @throws Exception
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
     * 检查是否授权.
     * @param string $code 请求编号
     */
    public static function query(string $code): ?array
    {
        return Library::$sapp->cache->get(self::gauth($code));
    }

    /**
     * 删除授权缓存.
     */
    public static function remove(string $code): bool
    {
        return Library::$sapp->cache->delete(self::gauth($code));
    }
}
