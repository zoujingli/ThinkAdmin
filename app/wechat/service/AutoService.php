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

use app\wechat\model\WechatAuto;
use think\admin\Service;
use think\admin\service\QueueService;

/**
 * 关注自动回复服务
 * @class AutoService
 * @package app\wechat\service
 */
class AutoService extends Service
{
    /**
     * 注册微信用户推送任务
     * @param string $openid
     * @throws \think\admin\Exception
     */
    public static function register(string $openid)
    {
        foreach (WechatAuto::mk()->where(['status' => 1])->order('time asc')->cursor() as $vo) {
            [$name, $time] = ["推送客服消息 {$vo['code']}#{$openid}", static::parseTimeString($vo['time'])];
            QueueService::register($name, "xadmin:fansmsg {$openid} {$vo['code']}", $time);
        }
    }

    /**
     * 解析配置时间格式
     * @param string $time
     * @return int
     */
    private static function parseTimeString(string $time): int
    {
        if (preg_match('|^.*?(\d{2}).*?(\d{2}).*?(\d{2}).*?$|', $time, $vars)) {
            return intval($vars[1]) * 3600 * intval($vars[2]) * 60 + intval($vars[3]);
        } else {
            return 0;
        }
    }
}