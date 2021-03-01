<?php

namespace app\data\command;

use app\data\service\UserService;
use think\admin\Command;
use think\admin\Exception;
use think\console\Input;
use think\console\Output;

/**
 * 用户余额重算处理
 * Class UserBalance
 * @package app\data\command
 */
class UserBalance extends Command
{
    protected function configure()
    {
        $this->setName('xdata:UserBalance');
        $this->setDescription('批量重新计算用户余额');
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
                $this->queue->message($total, ++$count, "正在计算用户 [{$user['id']}] 的余额");
                UserService::instance()->balance($user['id']);
                $this->queue->message($total, $count, "完成计算用户 [{$user['id']}] 的余额", 1);
            }
        } catch (\Exception $exception) {
            $this->queue->error($exception->getMessage());
        }
    }
}