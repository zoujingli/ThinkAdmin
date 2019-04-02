<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\command\task;

use library\command\Task;

/**
 * Class TaskState
 * @package library\command\task
 */
class State extends Task
{

    protected function configure()
    {
        $this->setName('xtask:state')->setDescription('view message queue daemon');
    }
    
    protected function execute(\think\console\Input $input, \think\console\Output $output)
    {
        if (($pid = $this->checkProcess()) > 0) {
            $output->info("message queue daemon {$pid} is runing.");
        } else {
            $output->info('The message queue daemon is not running.');
        }
    }

}