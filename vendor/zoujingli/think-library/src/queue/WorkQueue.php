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
use think\Console;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\Db;
use think\Exception;

/**
 * 启动独立执行进程
 * Class WorkQueue
 * @package library\queue
 */
class WorkQueue extends Command
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
        $this->setName('xtask:_work')->setDescription('Create a process to execute a task');
        $this->addArgument('id', Argument::OPTIONAL, 'TaskNumber');
        $this->addArgument('sp', Argument::OPTIONAL, 'Separator');
    }

    /**
     * 任务执行
     * @param Input $input
     * @param Output $output
     * @throws Exception
     * @throws \think\exception\PDOException
     */
    protected function execute(Input $input, Output $output)
    {
        $this->id = trim($input->getArgument('id'));
        if (empty($this->id)) {
            $this->output->error('Task number needs to be specified for task execution');
        } else try {
            $queue = Db::name('SystemQueue')->where(['id' => $this->id, 'status' => '1'])->find();
            if (empty($queue)) {
                // 这里不做任何处理（该任务可能在其它地方已经在执行）
                $this->output->warning("The or status of task {$this->id} is abnormal");
            } else {
                // 锁定任务状态
                Db::name('SystemQueue')->where(['id' => $queue['id']])->update(['status' => '2', 'start_at' => date('Y-m-d H:i:s')]);
                // 设置进程标题
                if (($process = ProcessService::instance())->iswin() && function_exists('cli_set_process_title')) {
                    cli_set_process_title("ThinkAdmin {$process->version()} Queue - {$queue['title']}");
                }
                // 执行任务内容
                if (class_exists($queue['preload'])) {
                    // 自定义文件，支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    if (method_exists($class = new $queue['preload'], 'execute')) {
                        $data = json_decode($queue['data'], true);
                        if (isset($class->jobid)) $class->jobid = $this->id;
                        if (isset($class->title)) $class->title = $queue['title'];
                        $this->update('3', $class->execute($input, $output, is_array($data) ? $data : []));
                    } else {
                        throw new Exception("Task processing class {$queue['preload']} not defined execute");
                    }
                } else {
                    // 自定义指令，不支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    $attr = explode(' ', trim(preg_replace('|\s+|', ' ', $queue['preload'])));
                    $this->update('3', Console::call(array_shift($attr), $attr)->fetch());
                }
            }
        } catch (\Exception $e) {
            if (in_array($e->getCode(), ['3', '4'])) {
                $this->update($e->getCode(), $e->getMessage());
            } else {
                $this->update('4', $e->getMessage());
            }
        }
    }

    /**
     * 修改当前任务状态
     * @param mixed $status 任务状态
     * @param mixed $message 消息内容
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function update($status, $message)
    {
        $desc = explode("\n", trim(is_string($message) ? $message : ''));
        $result = Db::name('SystemQueue')->where(['id' => $this->id])->update([
            'status' => $status, 'end_at' => date('Y-m-d H:i:s'), 'desc' => $desc[0],
        ]);
        $this->output->writeln(is_string($message) ? $message : '');
        return $result !== false;
    }

}
