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

use Exception;
use library\command\Task;
use think\Console;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\Db;

/**
 * 启动指定独立执行的任务子进程
 * Class Work
 * @package library\command\task
 */
class Work extends Task
{

    /**
     * 当前任务ID
     * @var integer
     */
    protected $id;

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'SystemQueue';

    /**
     * 配置指定信息
     */
    protected function configure()
    {
        // 执行任务配置
        $this->setName('xtask:_work')->setDescription('[执行]创建执行单个指定任务的进程');
        $this->addArgument('id', Argument::OPTIONAL, '指定任务ID');
        $this->addArgument('sp', Argument::OPTIONAL, '指令结束符');
    }

    /**
     * 任务执行
     * @param Input $input
     * @param Output $output
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function execute(Input $input, Output $output)
    {
        try {
            $this->id = trim($input->getArgument('id')) ?: 0;
            if (empty($this->id)) throw new Exception("执行任务需要指定任务编号！");
            $queue = Db::name('SystemQueue')->where(['id' => $this->id, 'status' => '2'])->find();
            if (empty($queue)) throw new Exception("执行任务{$this->id}的信息或状态异常！");
            // 设置进程标题
            if ($this->isWin() && function_exists('cli_set_process_title')) {
                cli_set_process_title("ThinkAdmin {$this->version} 异步任务执行子进程 - {$queue['title']}");
            }
            // 执行任务内容
            if (class_exists($queue['preload'])) {
                if (method_exists($class = new $queue['preload'], 'execute')) {
                    $data = json_decode($queue['data'], true);
                    $this->update('3', $class->execute($input, $output, is_array($data) ? $data : []));
                } else throw new Exception("任务处理类 {$queue['preload']} 未定义 execute 入口！");
            } else {
                $this->update('3', Console::call($queue['preload'], [], 'console'));
            }
        } catch (Exception $e) {
            $this->update('4', $e->getMessage());
        }
    }

    /**
     * 修改当前任务状态
     * @param integer $status 任务状态
     * @param string $message 消息内容
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function update($status, $message)
    {
        $result = Db::name('SystemQueue')->where(['id' => $this->id])->update([
            'status' => $status, 'end_at' => date('Y-m-d H:i:s'),
            'desc'   => is_string($message) ? $message : '',
        ]);
        $this->output->writeln(is_string($message) ? $message : '');
        return $result !== false;
    }

}
