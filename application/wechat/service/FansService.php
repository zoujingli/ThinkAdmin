<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\service;

use service\DataService;
use service\ToolsService;
use service\WechatService;
use think\Db;

/**
 * 微信粉丝数据服务
 * Class FansService
 * @package app\wechat
 */
class FansService
{
    /**
     * 增加或更新粉丝信息
     * @param array $user
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function set(array $user)
    {
        $user['appid'] = WechatService::getAppid();
        if (!empty($user['subscribe_time'])) {
            $user['subscribe_at'] = date('Y-m-d H:i:s', $user['subscribe_time']);
        }
        if (isset($user['tagid_list']) && is_array($user['tagid_list'])) {
            $user['tagid_list'] = join(',', $user['tagid_list']);
        }
        foreach (['country', 'province', 'city', 'nickname', 'remark'] as $field) {
            isset($user[$field]) && $user[$field] = ToolsService::emojiEncode($user[$field]);
        }
        unset($user['privilege'], $user['groupid']);
        return DataService::save('WechatFans', $user, 'openid');
    }

    /**
     * 获取粉丝信息
     * @param string $openid
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function get($openid)
    {
        $map = ['openid' => $openid, 'appid' => WechatService::getAppid()];
        $user = Db::name('WechatFans')->where($map)->find();
        foreach (['country', 'province', 'city', 'nickname', 'remark'] as $k) {
            isset($user[$k]) && $user[$k] = ToolsService::emojiDecode($user[$k]);
        }
        return $user;
    }

    /**
     * 同步所有粉丝记录
     * @param string $next_openid
     * @return bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function sync($next_openid = '')
    {
        $wechat = WechatService::user();
        $result = $wechat->getUserList($next_openid);
        if (empty($result['data']['openid'])) {
            return false;
        }
        foreach (array_chunk($result['data']['openid'], 100) as $openids) {
            foreach ($wechat->getBatchUserInfo($openids)['user_info_list'] as $user) {
                if (false === self::set($user)) {
                    return false;
                }
                if ($result['next_openid'] === $user['openid']) {
                    unset($result['next_openid']);
                }
            }
        }
        return empty($result['next_openid']) ? true : self::sync($result['next_openid']);
    }

    /**
     * 同步获取黑名单信息
     * @param string $next_openid
     * @return bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function syncBlack($next_openid = '')
    {
        $wechat = WechatService::user();
        $result = $wechat->getBlackList($next_openid);
        foreach (array_chunk($result['data']['openid'], 100) as $openids) {
            $info = $wechat->getBatchUserInfo($openids);
            foreach ($info as $user) {
                $user['is_black'] = '1';
                if (self::set($user) && $result['next_openid'] === $user['openid']) {
                    unset($result['next_openid']);
                }
            }
        }
        return empty($result['next_openid']) ? true : self::syncBlack($result['next_openid']);
    }

}