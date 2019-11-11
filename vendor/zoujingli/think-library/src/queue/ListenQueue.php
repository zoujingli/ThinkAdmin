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

namespace think\admin\queue;

use think\admin\service\ProcessService;
use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 启动监听异步任务守护的主进程
 * Class ListenQueue
 * @package think\admin\queue
 */
class ListenQueue extends Command
{
    /**
     * 配置指定信息
     */
    protected function configure()
    {
        $this->setName('xtask:listen')->setDescription('[监听]常驻异步任务循环监听主进程');
    }

    /**
     * 执行进程守护监听
     * @param Input $input
     * @param Output $output
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function execute(Input $input, Output $output)
    {
        $this->app->db->name('SystemQueue')->count();
        if (($process = ProcessService::instance($this->app))->iswin()) {
            $this->setProcessTitle("ThinkAdmin 异步任务监听主进程 {$process->version()}");
        }
        $output->comment('============ 异步任务监听中 ============');
        while (true) {
            foreach ($this->app->db->name('SystemQueue')->where([['status', '=', '1'], ['exec_time', '<=', time()]])->order('exec_time asc')->select() as $vo) {
                try {
                    $this->app->db->name('SystemQueue')->where(['id' => $vo['id']])->update(['status' => '2', 'enter_time' => time(), 'attempts' => $vo['attempts'] + 1]);
                    if ($process->query($command = $process->think("xtask:_work {$vo['id']} -"))) {
                        $output->comment("任务正在执行 --> [{$vo['id']}] {$vo['title']}");
                    } else {
                        $process->create($command);
                        $output->info("任务创建成功 --> [{$vo['id']}] {$vo['title']}");
                    }
                } catch (\Exception $e) {
                    $this->app->db->name('SystemQueue')->where(['id' => $vo['id']])->update(['status' => '4', 'outer_time' => time(), 'exec_desc' => $e->getMessage()]);
                    $output->error("任务创建失败 --> [{$vo['id']}] {$vo['title']}，{$e->getMessage()}");
                }
            }
            sleep(1);
        }
    }

}
