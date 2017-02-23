<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace service;

use library\Data;
use think\Cache;
use think\Db;
use think\Log;

/**
 * 微信粉丝数据服务
 *
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/10/24 17:01
 */
class FansService {

    /**
     * 从微信服务器获取所有标签
     * @param $appid
     * @return bool
     */
    static public function syncTags($appid) {
        $wechat = &load_wechat("User", $appid);
        if (($result = $wechat->getTags()) !== FALSE) {
            $tags = $result['tags'];
            foreach ($tags as &$tag) {
                $tag['appid'] = $appid;
            }
            Db::table('wechat_fans_tags')->where('appid', $appid)->delete();
            foreach (array_chunk($tags, 100) as $list) {
                Db::table('wechat_fans_tags')->insertAll($list);
            }
            return true;
        }
        return true;
    }

    /**
     * 同步粉丝的标签
     * @param string $appid
     * @param string $openid
     * @return bool
     */
    static public function syncFansTags($appid, $openid) {
        $wechat = &load_wechat('User', $appid);
        $tagsid = $wechat->getUserTags($openid);
        if ($tagsid === false || !is_array($tagsid)) {
            return false;
        }
        return Data::save('wechat_fans', ['appid' => $appid, 'openid' => $openid, 'tagid_list' => join(',', $tagsid)], 'openid', ['appid' => $appid]);
    }

    /**
     * 保存/更新粉丝信息
     * @param array $userInfo
     * @param string $appid
     * @return bool
     */
    static public function set($userInfo, $appid = '') {
        if (!empty($userInfo['subscribe_time'])) {
            $userInfo['subscribe_at'] = date('Y-m-d H:i:s', $userInfo['subscribe_time']);
        }
        if (!empty($userInfo['tagid_list']) && is_array($userInfo['tagid_list'])) {
            $userInfo['tagid_list'] = join(',', $userInfo['tagid_list']);
        }
        $userInfo['appid'] = $appid;
        return Data::save('wechat_fans', $userInfo, 'openid');
    }

    /**
     * 读取粉丝信息
     * @param string $openid
     * @return array|false
     */
    static public function get($openid) {
        return Db::table('wechat_fans')->where('openid', $openid)->find();
    }

    /**
     * 同步获取粉丝列表
     * @param string $appid
     * @param string $next_openid
     * @return bool
     */
    static public function sync($appid, $next_openid = '') {
        $wechat = &load_wechat('User', $appid);
        $result = $wechat->getUserList($next_openid);
        if ($result === FALSE || empty($result['data']['openid'])) {
            Log::record("获取粉丝列表失败，{$wechat->errMsg} [{$wechat->errCode}]", Log::ERROR);
            return FALSE;
        }
        foreach ($result['data']['openid'] as $openid) {
            if (FALSE === ($userInfo = $wechat->getUserInfo($openid))) {
                Log::record("获取用户[{$openid}]信息失败，$wechat->errMsg", Log::ERROR);
                return FALSE;
            }
            if (FALSE === self::set($userInfo, $wechat->appid)) {
                Log::record('更新粉丝信息更新失败！', Log::ERROR);
                return FALSE;
            }
            if ($result['next_openid'] === $openid) {
                unset($result['next_openid']);
            }
        }
        return !empty($result['next_openid']) ? self::sync($appid, $result['next_openid']) : TRUE;
    }

    /**
     * 同步获取黑名单信息
     * @param string $appid
     * @param string $next_openid
     * @return bool
     */
    static public function syncBlacklist($appid, $next_openid = '') {
        $wechat = &load_wechat('User');
        $result = $wechat->getBacklist($next_openid);

        if ($result === FALSE || (empty($result['data']['openid']))) {
            if (empty($result['total'])) {
                return TRUE;
            }
            Log::record("获取粉丝黑名单列表失败，{$wechat->errMsg} [{$wechat->errCode}]", Log::ERROR);
            return FALSE;
        }
        foreach ($result['data']['openid'] as $openid) {
            if (FALSE === ($userInfo = $wechat->getUserInfo($openid))) {
                Log::record("获取用户[{$openid}]信息失败，$wechat->errMsg", Log::ERROR);
                return FALSE;
            }
            $userInfo['is_back'] = '1';
            if (FALSE === self::set($userInfo)) {
                Log::record('更新粉丝信息更新失败！', Log::ERROR);
                return FALSE;
            }
            if ($result['next_openid'] === $openid) {
                unset($result['next_openid']);
            }
        }
        return !empty($result['next_openid']) ? self::sync_blacklist($appid, $result['next_openid']) : TRUE;
    }

    /**
     * 读取七天的统计数据
     * @param string $appid
     * @param int $day
     * @return array
     */
    static public function getTotal($appid, $day = 7) {
        $result = Cache::get(($cachekey = "wechat_token_{$appid}"));
        if (!empty($result)) {
            return $result;
        }
        $extends = &load_wechat('Extends', $appid);
        // 统计总数
        $data['cumulate'] = (array) $extends->getDatacube('user', 'cumulate', date('Y-m-d', strtotime("-{$day} day")), date('Y-m-d', strtotime('-1 day')));
        // 统计增量数
        $data['summary'] = (array) $extends->getDatacube('user', 'summary', date('Y-m-d', strtotime("-{$day} day")), date('Y-m-d', strtotime('-1 day')));
        // 统计消息数
        $data['upstreammsg'] = (array) $extends->getDatacube('upstreammsg', 'summary', date('Y-m-d', strtotime("-{$day} day")), date('Y-m-d', strtotime('-1 day')));
        $temp = array();
        for ($i = 1; $i <= $day; $i++) {
            $temp[date('Y-m-d', strtotime("-{$i} day"))] = [];
        }
        foreach ($data as $vo) {
            foreach ($vo as $v) {
                isset($v['ref_date']) && ($temp[$v['ref_date']] = array_merge($temp[$v['ref_date']], $v));
            }
        }
        ksort($temp);
        Cache::set($cachekey, $temp, 600);
        return $temp;
    }

}
