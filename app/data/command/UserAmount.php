<?php

namespace app\data\command;

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
        try {
            [$total, $count] = [$this->app->db->name('DataUser')->count(), 0];
            foreach ($this->app->db->name('DataUser')->field('id')->cursor() as $user) {
                $this->queue->message($total, ++$count, "正在计算用户 [{$user['id']}] 的余额和返利");
                UserRebateService::instance()->amount($user['id']);
                UserBalanceService::instance()->amount($user['id']);
                $this->queue->message($total, $count, "完成计算用户 [{$user['id']}] 的余额和返利", 1);
            }
        } catch (\Exception $exception) {
            $this->queue->error($exception->getMessage());
        }
    }
}