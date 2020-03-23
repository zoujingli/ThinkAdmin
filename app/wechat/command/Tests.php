<?php


namespace app\wechat\command;

use think\admin\Command;
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
        $max = 10000;
        for ($i = 0; $i < $max; $i++) {
            $this->queueProgressMessage(2, "已经完成了 $i 的计算", $i / $max * 100);
            usleep(5000);
        }
    }

}