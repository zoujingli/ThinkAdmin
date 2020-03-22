<?php


namespace app\wechat\command;

use think\admin\service\QueueService;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Tests extends Command
{
    protected function configure()
    {
        $this->setName('xadmin:tests')->setDescription('指令类任务测试');
    }

    protected function execute(Input $input, Output $output)
    {
        $max = 100;
        for ($i = 0; $i < $max; $i++) {
            echo $i . PHP_EOL;
            if (defined('WorkQueueCode')) {
                QueueService::instance()->progress(WorkQueueCode, 2, "已经完成了 $i 的计算", $i / $max * 100);
            }
            sleep(1);
        }
    }

}