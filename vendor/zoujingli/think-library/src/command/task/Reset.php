<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\command\task;

use library\command\Task;

/**
 * Class Reset
 * @package library\command\task
 */
class Reset extends Task
{

    protected function configure()
    {
        $this->setName('xtask:reset')->setDescription('重新启动消息队列守护进程');
    }

    protected function execute(\think\console\Input $input, \think\console\Output $output)
    {
        if (($pid = $this->checkProcess()) > 0) {
            $this->closeProcess($pid);
            $output->info("message queue daemon {$pid} closed successfully!");
        }
        $this->createProcess();
        if ($pid = $this->checkProcess()) {
            $output->info("message queue daemon {$pid} created successfully!");
        } else {
            $output->error('message queue daemon creation failed, try again later!');
        }
    }
}
