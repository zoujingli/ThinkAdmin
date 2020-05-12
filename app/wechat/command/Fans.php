<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
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
        $this->setName('xadmin:fansall')->setDescription('Wechat Users Data Synchronize for ThinkAdmin');
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
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _list($next = '', $done = 0)
    {
        $appid = WechatService::instance()->getAppid();
        $this->output->comment('--> Start to synchronize wechat user data');
        while (!is_null($next) && is_array($result = WechatService::WeChatUser()->getUserList($next)) && !empty($result['data']['openid'])) {
            foreach (array_chunk($result['data']['openid'], 100) as $openids) {
                if (is_array($list = WechatService::WeChatUser()->getBatchUserInfo($openids)) && !empty($list['user_info_list'])) {
                    foreach ($list['user_info_list'] as $user) {
                        $string = str_pad(++$done, strlen($result['total']), '0', STR_PAD_LEFT);
                        $message = "({$string}/{$result['total']}) -> {$user['openid']} {$user['nickname']}";
                        $this->setQueueProgress($message, $done * 100 / $result['total']);
                        FansService::instance()->set($user, $appid);
                    }
                }
            }
            $next = $result['total'] > $done ? $result['next_openid'] : null;
        }
        $this->output->comment('--> Wechat user data synchronization completed');
        $this->output->newLine();
        return "同步{$done}个用户数据";
    }

    /**
     * 同步粉丝黑名单列表
     * @param string $next
     * @param integer $done
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function _black($next = '', $done = 0)
    {
        $wechat = WechatService::WeChatUser();
        $this->output->comment('--> Start to synchronize wechat blacklist data');
        while (!is_null($next) && is_array($result = $wechat->getBlackList($next)) && !empty($result['data']['openid'])) {
            $done += $result['count'];
            foreach (array_chunk($result['data']['openid'], 100) as $chunk) {
                $this->app->db->name('WechatFans')->where(['is_black' => '0'])->whereIn('openid', $chunk)->update(['is_black' => '1']);
            }
            $this->setQueueProgress("共计同步微信黑名单{$result['total']}人");
            $next = $result['total'] > $done ? $result['next_openid'] : null;
        }
        $this->output->comment('--> Wechat blacklist data synchronization completed');
        $this->output->newLine();
        if (empty($result['total'])) {
            return '，其中黑名单0人';
        } else {
            return "，其中黑名单{$result['total']}人";
        }
    }

    /**
     * 同步粉丝标签列表
     * @param integer $index
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function _tags($index = 0)
    {
        $appid = WechatService::instance()->getAppid();
        $this->output->comment('--> Start to synchronize wechat tag data');
        if (is_array($list = WechatService::WeChatTags()->getTags()) && !empty($list['tags'])) {
            $count = count($list['tags']);
            foreach ($list['tags'] as &$tag) {
                $tag['appid'] = $appid;
                $progress = str_pad(++$index, strlen($count), '0', STR_PAD_LEFT);
                $this->setQueueProgress("({$progress}/{$count}) -> {$tag['name']}");
            }
            $this->app->db->name('WechatFansTags')->where(['appid' => $appid])->delete();
            $this->app->db->name('WechatFansTags')->insertAll($list['tags']);
        }
        $this->output->comment('--> Wechat tag data synchronization completed');
        $this->output->newLine();
        return "，同步{$index}个标签。";
    }

}