<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\wechat\command;

use app\wechat\service\WechatService;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

/**
 * 微信粉丝管理
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
     * 执行指令
     * @param Input $input
     * @param Output $output
     * @return int|void|null
     */
    protected function execute(Input $input, Output $output)
    {
        # $output->writeln('preparing for synchronization of fan command...');
        foreach ($this->module as $m) {
            if (method_exists($this, $fun = "_{$m}")) $this->$fun();
        }
        # $output->writeln('synchronized fans command completion.');
    }


    /**
     * 同步微信粉丝列表
     * @param string $next
     * @param integer $index
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function _list($next = '', $index = 0)
    {
        $appid = WechatService::getAppid();
        $wechat = WechatService::WeChatUser();
        $this->output->comment('preparing synchronize fans list ...');
        while (true) if (is_array($result = $wechat->getUserList($next)) && !empty($result['data']['openid'])) {
            foreach (array_chunk($result['data']['openid'], 100) as $chunk) {
                if (is_array($list = $wechat->getBatchUserInfo($chunk)) && !empty($list['user_info_list'])) {
                    foreach ($list['user_info_list'] as $user) {
                        $indexString = str_pad(++$index, strlen($result['total']), '0', STR_PAD_LEFT);
                        $this->output->writeln("({$indexString}/{$result['total']}) updating wechat user {$user['openid']} {$user['nickname']}");
                        \app\wechat\service\FansService::set($user, $appid);
                    }
                }
            }
            if (in_array($result['next_openid'], $result['data']['openid'])) break;
            else $next = $result['next_openid'];
        }
        $this->output->comment('synchronized fans list successful.');
    }

    /**
     * 同步粉丝黑名单列表
     * @param string $next
     * @param integer $index
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function _black($next = '', $index = 0)
    {
        $wechat = WechatService::WeChatUser();
        $this->output->comment('prepare synchronize fans black ...');
        while (true) if (is_array($result = $wechat->getBlackList($next)) && !empty($result['data']['openid'])) {
            foreach (array_chunk($result['data']['openid'], 100) as $chunk) {
                foreach ($chunk as $openid) {
                    $indexString = str_pad(++$index, strlen($result['total']), '0', STR_PAD_LEFT);
                    $this->output->writeln("({$indexString}/{$result['total']}) updating wechat black {$openid}");
                }
                $where = [['is_black', 'eq', '0'], ['openid', 'in', $chunk]];
                Db::name('WechatFans')->where($where)->update(['is_black' => '1']);
            }
            if (in_array($result['next_openid'], $result['data']['openid'])) break;
            else $next = $result['next_openid'];
        }
        $this->output->comment('synchronized fans black successful.');
    }

    /**
     * 同步粉丝标签列表
     * @param integer $index
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function _tags($index = 0)
    {
        $appid = WechatService::getAppid();
        $wechat = WechatService::WeChatTags();
        $this->output->comment('prepare synchronize fans tags ...');
        if (is_array($list = $wechat->getTags()) && !empty($list['tags'])) {
            $count = count($list['tags']);
            foreach ($list['tags'] as &$tag) {
                $tag['appid'] = $appid;
                $indexString = str_pad(++$index, strlen($count), '0', STR_PAD_LEFT);
                $this->output->writeln("({$indexString}/{$count}) updating wechat tags {$tag['name']}");
            }
            Db::name('WechatFansTags')->where(['appid' => $appid])->delete();
            Db::name('WechatFansTags')->insertAll($list['tags']);
        }
        $this->output->comment('synchronized fans tags successful.');
    }

}