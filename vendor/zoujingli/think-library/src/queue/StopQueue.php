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

namespace library\queue;

use library\service\ProcessService;
use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 平滑停止任务的所有进程
 * Class StopQueue
 * @package library\queue
 */
class StopQueue extends Command
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xtask:stop')->setDescription('[控制]平滑停止所有的进程');
    }

    /**
     * 停止所有任务执行
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $process = ProcessService::instance();
        $command = $process->think('xtask:');
        if (count($result = $process->query($command)) < 1) {
            $output->writeln("没有需要结束的任务进程哦！");
        } else foreach ($result as $item) {
            $process->close($item['pid']);
            $output->writeln("发送结束进程{$item['pid']}信号成功！");
        }
    }
}
