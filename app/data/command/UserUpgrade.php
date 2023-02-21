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
use app\data\service\UserUpgradeService;
use think\admin\Command;
use think\admin\Exception;
use think\console\Input;
use think\console\Output;

/**
 * 用户等级重算处理
 * Class UserLevel
 * @package app\data\command
 */
class UserUpgrade extends Command
{
    protected function configure()
    {
        $this->setName('xdata:UserUpgrade');
        $this->setDescription('批量重新计算用户等级');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws Exception
     */
    protected function execute(Input $input, Output $output)
    {
        try {
            [$total, $count] = [DataUser::mk()->count(), 0];
            foreach (DataUser::mk()->field('id')->cursor() as $user) {
                $this->queue->message($total, ++$count, "正在计算用户 [{$user['id']}] 的等级");
                UserUpgradeService::upgrade($user['id']);
                $this->queue->message($total, $count, "完成计算用户 [{$user['id']}] 的等级", 1);
            }
            $this->setQueueSuccess("此次共重新计算 {$total} 个用户等级。");
        } catch (Exception $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->setQueueError($exception->getMessage());
        }
    }
}