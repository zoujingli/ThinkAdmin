<?php

namespace app\wechat\service;

use think\admin\Service;
use think\admin\service\QueueService;

/**
 * 关注自动回复服务
 * Class AutoService
 * @package app\wechat\service
 */
class AutoService extends Service
{
    /**
     * 注册微信用户推送任务
     * @param string $openid
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function register(string $openid)
    {
        foreach ($this->app->db->name('WechatAuto')->where(['status' => 1])->order('time asc')->cursor() as $vo) {
            $time = $this->parseTimeString($vo['time']);
            $name = "延迟向用户 {$openid} 推送 {$vo['code']} 客服消息";
            QueueService::instance()->register($name, "xadmin:fansmsg {$openid} {$vo['code']}", $time);
        }
    }

    /**
     * 解析配置时间格式
     * @param string $time
     * @return int
     */
    private function parseTimeString(string $time): int
    {
        if (preg_match('|^.*?(\d{2}).*?(\d{2}).*?(\d{2}).*?$|', $time, $vars)) {
            return intval($vars[1]) * 3600 * intval($vars[2]) * 60 + intval($vars[3]);
        } else {
            return 0;
        }
    }
}