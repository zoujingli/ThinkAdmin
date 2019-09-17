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

namespace app\wechat\queue;

use app\admin\queue\Queue;
use app\wechat\service\FansService;
use app\wechat\service\WechatService;
use think\console\Input;
use think\console\Output;
use think\Db;

/**
 * Class Jobs
 * @package app\wechat
 */
class WechatQueue extends Queue
{

    /**
     * 当前类名
     * @var string
     */
    const URI = self::class;

    /**
     * 执行任务
     * @param Input $input
     * @param Output $output
     * @param array $data
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function execute(Input $input, Output $output, array $data = [])
    {
        $appid = WechatService::getAppid();
        $wechat = WechatService::WeChatUser();
        // 获取远程粉丝
        list($next, $done) = ['', 0];
        while (!is_null($next) && is_array($result = $wechat->getUserList($next)) && !empty($result['data']['openid'])) {
            $done += $result['count'];
            foreach (array_chunk($result['data']['openid'], 100) as $chunk) {
                if (is_array($list = $wechat->getBatchUserInfo($chunk)) && !empty($list['user_info_list'])) {
                    foreach ($list['user_info_list'] as $user) FansService::set($user, $appid);
                }
            }
            $next = $result['total'] > $done ? $result['next_openid'] : null;
        }
        // 同步粉丝黑名单
        list($next, $done) = ['', 0];
        while (!is_null($next) && is_array($result = $wechat->getBlackList($next)) && !empty($result['data']['openid'])) {
            $done += $result['count'];
            foreach (array_chunk($result['data']['openid'], 100) as $chunk) {
                Db::name('WechatFans')->where(['is_black' => '0'])->whereIn('openid', $chunk)->update(['is_black' => '1']);
            }
            $next = $result['total'] > $done ? $result['next_openid'] : null;
        }
        // 同步粉丝标签
        if (is_array($list = WechatService::WeChatTags()->getTags()) && !empty($list['tags'])) {
            foreach ($list['tags'] as &$tag) $tag['appid'] = $appid;
            Db::name('WechatFansTags')->where('1=1')->delete();
            Db::name('WechatFansTags')->insertAll($list['tags']);
        }
    }

}
