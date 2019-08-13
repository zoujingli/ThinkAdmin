<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\queue\task;

use library\command\Task;
use think\console\Input;
use think\console\Output;

/**
 * 平滑停止异步任务守护的主进程
 * Class Stop
 * @package app\admin\queue\task
 */
class Stop extends Task
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xqueue:stop')->setDescription('平滑停止异步任务守护的主进程');
    }

    /**
     * 停止所有任务执行
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $this->cmd = "{$this->bin} xqueue:";
        foreach ($this->queryProcess() as $item) {
            $this->closeProcess($item['pid']);
            $output->comment(">>> 给进程{$item['pid']}发送结束指令成功");
        }
        $output->comment(">>> 所有异步任务进程的结束指令发送成功");
    }
}
