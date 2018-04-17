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
use service\WechatService;
use think\Db;

/**
 * 粉丝标签服务
 * Class TagsService
 * @package app\wechat\service
 */
class TagsService
{
    /**
     * 同步粉丝的标签
     * @param string $openid
     * @return bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function syncTagsByOpenid($openid)
    {
        $tagsid = WechatService::tags()->getUserTagId($openid);
        if (!is_array($tagsid)) {
            return false;
        }
        $data = ['openid' => $openid, 'tagid_list' => join(',', $tagsid)];
        return DataService::save('WechatFans', $data, 'openid', ['appid' => sysconf('wechat_appid')]);
    }

    /**
     * 从微信服务器获取所有标签
     * @return bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function sync()
    {
        $appid = WechatService::getAppid();
        $result = WechatService::tags()->getTags();
        Db::name('WechatFansTags')->where(['appid' => $appid])->delete();
        foreach (array_chunk($result['tags'], 100) as $list) {
            foreach ($list as &$vo) {
                $vo['appid'] = $appid;
            }
            Db::name('WechatFansTags')->insertAll($list);
        }
        return true;
    }

}