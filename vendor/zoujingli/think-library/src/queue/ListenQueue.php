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
 * 启动监听任务的主进程
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
        $this->setName('xtask:listen')->setDescription('[监听]启动任务监听主进程');
    }

    /**
     * 启动进程守护监听
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function execute(Input $input, Output $output)
    {
        set_time_limit(0);
        $this->app->db->name('SystemQueue')->count();
        if (($process = ProcessService::instance())->iswin()) {
            $this->setProcessTitle("ThinkAdmin 监听主进程 {$process->version()}");
        }
        $output->writeln('============ 任务监听中 ============');
        while (true) {
            $where = [['status', '=', '1'], ['exec_time', '<=', time()]];
            $this->app->db->name('SystemQueue')->where($where)->order('exec_time asc')->limit(100)->select()->each(function ($vo) use ($process) {
                try {
                    $command = $process->think("xtask:_work {$vo['code']} -");
                    if (count($process->query($command)) > 0) {
                        $this->output->warning("正在执行 -> [{$vo['code']}] {$vo['title']}");
                    } else {
                        $process->create($command);
                        $this->output->info("开始执行 -> [{$vo['code']}] {$vo['title']}");
                    }
                } catch (\Exception $e) {
                    $this->update($vo['code'], ['status' => '4', 'outer_time' => time(), 'exec_desc' => $e->getMessage()]);
                    $this->output->error("执行失败 -> [{$vo['code']}] {$vo['title']}，{$e->getMessage()}");
                }
            });
            sleep(1);
        }
    }

    /**
     * 更新任务数据
     * @param mixed $code 任务编号
     * @param mixed $data 任务数据
     * @return boolean
     * @throws \think\db\exception\DbException
     */
    protected function update($code, array $data = [])
    {
        return $this->app->db->name('SystemQueue')->where(['code' => $code])->update($data);
    }

}
