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

use think\admin\command\Queue;
use think\Collection;
use think\console\Input;
use think\console\Output;

/**
 * 启动监听任务的主进程
 * Class ListenQueue
 * @package think\admin\command\queue
 */
class ListenQueue extends Queue
{
    /**
     * 配置指定信息
     */
    protected function configure()
    {
        $this->setName('xtask:listen')->setDescription('Start task listening main process');
    }

    /**
     * 启动进程守护监听
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     */
    protected function execute(Input $input, Output $output)
    {
        set_time_limit(0);
        $this->app->db->name($this->table)->count();
        if ($this->process->iswin()) {
            $this->setProcessTitle("ThinkAdmin {$this->process->version()} Queue Listen");
        }
        $output->writeln('============ LISTENING ============');
        while (true) {
            $where = [['status', '=', '1'], ['exec_time', '<=', time()]];
            $this->app->db->name($this->table)->where($where)->order('exec_time asc')->chunk(100, function (Collection $list) {
                foreach ($list as $vo) try {
                    $command = $this->process->think("xtask:_work {$vo['code']} -");
                    if (count($this->process->query($command)) > 0) {
                        $this->output->writeln("Already in progress -> [{$vo['code']}] {$vo['title']}");
                    } else {
                        $this->process->create($command);
                        $this->output->writeln("Created new process -> [{$vo['code']}] {$vo['title']}");
                    }
                } catch (\Exception $exception) {
                    $this->update($vo['code'], ['status' => '4', 'outer_time' => time(), 'exec_desc' => $exception->getMessage()]);
                    $this->output->error("Execution failed -> [{$vo['code']}] {$vo['title']}，{$exception->getMessage()}");
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
        return $this->app->db->name($this->table)->where(['code' => $code])->update($data);
    }

}
