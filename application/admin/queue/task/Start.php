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
use think\Db;

/**
 * 检查并创建异步任务监听主进程
 * Class Start
 * @package app\admin\queue\task
 */
class Start extends Task
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xtask:start')->setDescription('[控制]创建异步任务守护监听主进程');
    }

    /**
     * 执行启动操作
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        Db::name('SystemQueue')->count();
        $this->setBaseProcess();
        if (($pid = $this->checkProcess()) > 0) {
            $output->info("异步任务监听主进程{$pid}已经启动！");
        } else {
            $this->setWinProcess();
            $this->createProcess();
            $this->setBaseProcess();
            $output->writeln('正在检查异步任务监听主进程状态...');
            sleep(1);
            if (($pid = $this->checkProcess()) > 0) {
                $output->info("异步任务监听主进程{$pid}启动成功！");
            } else {
                $output->error('异步任务监听主进程创建失败！');
            }
        }
    }

    private function setBaseProcess()
    {
        $this->cmd = "{$this->bin} xtask:listen";
    }

    private function setWinProcess()
    {
        if ($this->isWin()) {
            $command = env('runtime_path') . "queue" . DIRECTORY_SEPARATOR . "listen.cmd";
            file_exists(dirname($command)) or mkdir(dirname($command), 0755, true);
            file_put_contents($command, $this->cmd . PHP_EOL . 'del %~dp0%0 /y');
            $this->cmd = __DIR__ . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR . "process.exe {$command}";
        }
    }
}
