<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\command;

use app\wechat\service\FansService;
use app\wechat\service\WechatService;
use think\admin\Command;
use think\console\Input;
use think\console\Output;

/**
 * 微信粉丝管理指令
 * Class Fans
 * @package app\wechat\command
 */
class Fans extends Command
{
    /**
     * 需要处理的模块
     * @var array
     */
    protected $module = ['list', 'black', 'tags'];

    /**
     * 配置指令
     */
    protected function configure()
    {
        $this->setName('xadmin:fansall');
        $this->setDescription('Wechat Users Data Synchronize for ThinkAdmin');
    }

    /**
     * 执行指令
     * @param Input $input
     * @param Output $output
     * @throws \think\admin\Exception
     */
    protected function execute(Input $input, Output $output)
    {
        $message = '';
        foreach ($this->module as $m) {
            if (method_exists($this, $method = "_{$m}")) {
                $message .= $this->$method();
            }
        }
        $this->setQueueSuccess($message);
    }

    /**
     * 同步微信粉丝列表
     * @param string $next
     * @param integer $done
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _list(string $next = '', int $done = 0): string
    {
        $appid = WechatService::instance()->getAppid();
        $this->output->comment('开始获取微信用户数据');
        while (is_string($next)) {
            $result = WechatService::WeChatUser()->getUserList($next);
            if (is_array($result) && !empty($result['data']['openid'])) {
                foreach (array_chunk($result['data']['openid'], 100) as $openids) {
                    $info = WechatService::WeChatUser()->getBatchUserInfo($openids);
                    if (is_array($info) && !empty($info['user_info_list'])) {
                        foreach ($info['user_info_list'] as $user) {
                            $this->queue->message($result['total'], ++$done, "-> {$user['openid']} {$user['nickname']}");
                            FansService::instance()->set($user, $appid);
                        }
                    }
                }
                $next = $result['total'] > $done ? $result['next_openid'] : null;
            } else {
                $next = null;
            }
        }
        $this->output->comment($done > 0 ? '微信用户数据获取完成' : '未获取到微信用户数据');
        $this->output->newLine();
        return "共获取 {$done} 个用户数据";
    }

    /**
     * 同步粉丝黑名单列表
     * @param string $next
     * @param integer $done
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DbException
     */
    public function _black(string $next = '', int $done = 0): string
    {
        $wechat = WechatService::WeChatUser();
        $this->output->comment('开始更新黑名单的微信用户');
        while (!is_null($next) && is_array($result = $wechat->getBlackList($next)) && !empty($result['data']['openid'])) {
            $done += $result['count'];
            foreach (array_chunk($result['data']['openid'], 100) as $chunk) {
                $this->app->db->name('WechatFans')->where(['is_black' => '0'])->whereIn('openid', $chunk)->update(['is_black' => '1']);
            }
            $this->setQueueProgress("--> 共计同步微信黑名单{$result['total']}人");
            $next = $result['total'] > $done ? $result['next_openid'] : null;
        }
        $this->output->comment($done > 0 ? '黑名单的微信用户更新成功' : '未获取到黑名单微信用户哦');
        $this->output->newLine();
        if (empty($result['total'])) {
            return ', 其中黑名单 0 人';
        } else {
            return ", 其中黑名单 {$result['total']} 人";
        }
    }

    /**
     * 同步粉丝标签列表
     * @param integer $done
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function _tags(int $done = 0): string
    {
        $appid = WechatService::instance()->getAppid();
        $this->output->comment('开始获取微信用户标签数据');
        if (is_array($list = WechatService::WeChatTags()->getTags()) && !empty($list['tags'])) {
            $count = count($list['tags']);
            foreach ($list['tags'] as &$tag) {
                $tag['appid'] = $appid;
                $this->queue->message($count, ++$done, "-> {$tag['name']}");
            }
            $this->app->db->name('WechatFansTags')->where(['appid' => $appid])->delete();
            $this->app->db->name('WechatFansTags')->insertAll($list['tags']);
        }
        $this->output->comment($done > 0 ? '微信用户标签数据获取完成' : '未获取到微信用户标签数据');
        $this->output->newLine();
        return ", 获取到 {$done} 个标签";
    }

}