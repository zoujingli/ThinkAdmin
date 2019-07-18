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

use think\Db;

/**
 * 微信粉丝信息
 * Class FansService
 * @package app\wechat\service
 */
class FansService
{

    /**
     * 增加或更新粉丝信息
     * @param array $user 粉丝信息
     * @param string $appid 微信APPID
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function set(array $user, $appid = '')
    {
        if (!empty($user['subscribe_time'])) {
            $user['subscribe_at'] = date('Y-m-d H:i:s', $user['subscribe_time']);
        }
        if (isset($user['tagid_list']) && is_array($user['tagid_list'])) {
            $user['tagid_list'] = is_array($user['tagid_list']) ? join(',', $user['tagid_list']) : '';
        }
        if ($appid !== '') $user['appid'] = $appid;
        unset($user['privilege'], $user['groupid']);
        return data_save('WechatFans', $user, 'openid');
    }

    /**
     * 获取粉丝信息
     * @param string $openid
     * @return array|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function get($openid)
    {
        return Db::name('WechatFans')->where(['openid' => $openid])->find();
    }

}
