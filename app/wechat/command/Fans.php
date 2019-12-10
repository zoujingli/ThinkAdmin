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

namespace app\wechat\command;

use app\wechat\service\WechatService;
use think\console\Command;
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
    protected $module = ['list', 'tags', 'black'];

    /**
     * 执行指令
     * @param Input $input
     * @param Output $output
     * @return int|void|null
     */
    protected function execute(Input $input, Output $output)
    {
        foreach ($this->module as $m) {
            if (method_exists($this, $fun = "_{$m}")) $this->$fun();
        }
    }

    /**
     * 同步微信粉丝列表
     * @param string $next
     * @param integer $done
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _list($next = '', $done = 0)
    {
        $appid = WechatService::instance()->getAppid();
        $this->output->comment('开始同步微信粉丝数据');
        while (!is_null($next) && is_array($result = WechatService::WeChatUser()->getUserList($next)) && !empty($result['data']['openid'])) {
            foreach (array_chunk($result['data']['openid'], 100) as $openids) {
                if (is_array($list = WechatService::WeChatUser()->getBatchUserInfo($openids)) && !empty($list['user_info_list'])) {
                    foreach ($list['user_info_list'] as $user) {
                        $string = str_pad(++$done, strlen($result['total']), '0', STR_PAD_LEFT);
                        $this->output->writeln("({$string}/{$result['total']}) -> {$user['openid']} {$user['nickname']}");
                        \app\wechat\service\FansService::instance()->set($user, $appid);
                    }
                }
            }
            $next = $result['total'] > $done ? $result['next_openid'] : null;
        }
        $this->output->comment('微信粉丝数据同步完成！');
        $this->output->newLine();
    }

    /**
     * 同步粉丝黑名单列表
     * @param string $next
     * @param integer $done
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DbException
     */
    public function _black($next = '', $done = 0)
    {
        $wechat = WechatService::WeChatUser();
        $this->output->comment('开始同步微信黑名单数据 ...');
        while (!is_null($next) && is_array($result = $wechat->getBlackList($next)) && !empty($result['data']['openid'])) {
            $done += $result['count'];
            foreach (array_chunk($result['data']['openid'], 100) as $chunk) {
                $this->app->db->name('WechatFans')->where(['is_black' => '0'])->whereIn('openid', $chunk)->update(['is_black' => '1']);
            }
            $this->output->writeln("共计同步微信黑名单{$result['total']}人");
            $next = $result['total'] > $done ? $result['next_openid'] : null;
        }
        $this->output->comment('微信黑名单数据同步完成！');
        $this->output->newLine();
    }

    /**
     * 同步粉丝标签列表
     * @param integer $index
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function _tags($index = 0)
    {
        $wechat = WechatService::WeChatTags();
        $appid = WechatService::instance()->getAppid();
        $this->output->comment('同步微信粉丝标签数据...');
        if (is_array($list = $wechat->getTags()) && !empty($list['tags'])) {
            $count = count($list['tags']);
            foreach ($list['tags'] as &$tag) {
                $tag['appid'] = $appid;
                $indexString = str_pad(++$index, strlen($count), '0', STR_PAD_LEFT);
                $this->output->writeln("({$indexString}/{$count}) -> {$tag['name']}");
            }
            $this->app->db->name('WechatFansTags')->where(['appid' => $appid])->delete();
            $this->app->db->name('WechatFansTags')->insertAll($list['tags']);
        }
        $this->output->comment('微信粉丝标签数据同步完成！');
        $this->output->newLine();
    }

}