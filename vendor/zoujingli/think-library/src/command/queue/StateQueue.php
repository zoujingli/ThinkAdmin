<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\command\queue;

use think\admin\Command;
use think\console\Input;
use think\console\Output;

/**
 * 查看任务监听主进程状态
 * Class StateQueue
 * @package think\admin\command\queue
 */
class StateQueue extends Command
{
    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xtask:state')->setDescription('Check listening main process status');
    }

    /**
     * 指令执行状态
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $command = $this->process->think('xtask:listen');
        if (count($result = $this->process->query($command)) > 0) {
            $output->info("Listening for main process {$result[0]['pid']} running");
        } else {
            $output->warning("The Listening main process is not running");
        }
    }
}
