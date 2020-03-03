<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
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
 * 查询正在执行的进程PID
 * Class QueryQueue
 * @package library\queue
 */
class QueryQueue extends Command
{
    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xtask:query')->setDescription('Query all running task processes');
    }

    /**
     * 执行相关进程查询
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $process = ProcessService::instance();
        $result = $process->query($process->think("xtask:"));
        if (count($result) > 0) foreach ($result as $item) {
            $output->writeln("{$item['pid']}\t{$item['cmd']}");
        } else {
            $output->writeln('No related task process found');
        }
    }
}
