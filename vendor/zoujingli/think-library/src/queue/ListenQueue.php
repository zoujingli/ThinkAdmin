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
use think\Db;

/**
 * 启动监听任务的主进程
 * Class ListenQueue
 * @package library\queue
 */
class ListenQueue extends Command
{
    /**
     * 配置指定信息
     */
    protected function configure()
    {
        $this->setName('xtask:listen')->setDescription('[监听]启动任务监听主进程');
    }

    /**
     * 执行进程守护监听
     * @param Input $input
     * @param Output $output
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function execute(Input $input, Output $output)
    {
        Db::name('SystemQueue')->count();
        if (($process = ProcessService::instance())->iswin() && function_exists('cli_set_process_title')) {
            cli_set_process_title("ThinkAdmin 监听主进程 {$process->version()}");
        }
        $output->comment('============ 任务监听中 ============');
        while (true) {
            foreach (Db::name('SystemQueue')->where([['status', 'eq', '1'], ['time', '<=', time()]])->order('time asc')->select() as $item) {
                try {
                    if ($process->query($command = $process->think("xtask:_work {$item['id']} -"))) {
                        $output->comment("正在执行 -> [{$item['id']}] {$item['title']}");
                    } else {
                        $process->create($command);
                        $output->info("创建成功 -> [{$item['id']}] {$item['title']}");
                    }
                } catch (\Exception $e) {
                    Db::name('SystemQueue')->where(['id' => $item['id']])->update(['status' => '4', 'desc' => $e->getMessage()]);
                    $output->error("创建处理任务的子进程失败 --> [{$item['id']}] {$item['title']}，{$e->getMessage()}");
                }
            }
            sleep(1);
        }
    }

}
