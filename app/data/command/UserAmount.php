<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\command;

use app\data\model\DataUser;
use app\data\service\UserBalanceService;
use app\data\service\UserRebateService;
use think\admin\Command;
use think\admin\Exception;
use think\console\Input;
use think\console\Output;

/**
 * 用户余额及返利重算处理
 * Class UserBalance
 * @package app\data\command
 */
class UserAmount extends Command
{
    protected function configure()
    {
        $this->setName('xdata:UserAmount');
        $this->setDescription('批量重新计算余额返利');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws Exception
     */
    protected function execute(Input $input, Output $output)
    {
        [$total, $count, $error] = [DataUser::mk()->count(), 0, 0];
        foreach (DataUser::mk()->field('id')->cursor() as $user) try {
            $this->queue->message($total, ++$count, "刷新用户 [{$user['id']}] 余额及返利开始");
            UserRebateService::amount($user['id']) && UserBalanceService::amount($user['id']);
            $this->queue->message($total, $count, "刷新用户 [{$user['id']}] 余额及返利完成", 1);
        } catch (\Exception $exception) {
            $error++;
            $this->queue->message($total, $count, "刷新用户 [{$user['id']}] 余额及返利失败, {$exception->getMessage()}", 1);
        }
        $this->setQueueSuccess("此次共处理 {$total} 个刷新操作, 其中有 {$error} 个刷新失败。");
    }
}