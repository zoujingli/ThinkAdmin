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
use think\console\Input;
use think\console\Output;

/**
 * Class Start
 * @package library\command\task
 */
class Start extends Task
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xtask:start')->setDescription('开始启动消息队列守护进程');
    }

    /**
     * 执行启动操作
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        if (($pid = $this->checkProcess()) > 0) {
            $output->info("The message queue daemon {$pid} already exists!");
        } else {
            $this->createProcess();
            if (($pid = $this->checkProcess()) > 0) {
                $output->info("message queue daemon {$pid} created successfully!");
            } else {
                $output->error('message queue daemon creation failed, try again later!');
            }
        }
    }

}
