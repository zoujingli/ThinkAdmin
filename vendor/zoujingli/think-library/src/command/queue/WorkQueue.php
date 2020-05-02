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

use think\admin\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

/**
 * 启动独立执行进程
 * Class WorkQueue
 * @package think\admin\command\queue
 */
class WorkQueue extends Command
{
    /**
     * 执行任务编号
     * @var string
     */
    protected $code;

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'SystemQueue';

    /**
     * 配置指定参数
     */
    protected function configure()
    {
        $this->setName('xtask:_work')->setDescription('Create a process to execute task');
        $this->addArgument('code', Argument::OPTIONAL, 'TaskNumber');
        $this->addArgument('spts', Argument::OPTIONAL, 'Separator');
    }

    /**
     * 执行指令的任务
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     * @throws \think\db\exception\DbException
     */
    protected function execute(Input $input, Output $output)
    {
        set_time_limit(0);
        $this->code = trim($input->getArgument('code'));
        if (empty($this->code)) {
            $this->output->error('Task number needs to be specified for task execution');
        } else try {
            $this->queue->initialize($this->code);
            if (empty($this->queue->record) || intval($this->queue->record['status']) !== 1) {
                // 这里不做任何处理（该任务可能在其它地方已经在执行）
                $this->output->warning($message = "The or status of task {$this->code} is abnormal");
            } else {
                // 锁定任务状态，防止任务再次被执行
                $this->app->db->name($this->table)->strict(false)->where(['code' => $this->code])->update([
                    'enter_time' => microtime(true), 'attempts' => $this->app->db->raw('attempts+1'),
                    'outer_time' => '0', 'exec_pid' => getmypid(), 'exec_desc' => '', 'status' => '2',
                ]);
                $this->queue->progress(2, '>>> 任务处理开始 <<<', 0);
                // 设置进程标题
                if ($this->process->iswin()) {
                    $this->setProcessTitle("ThinkAdmin {$this->process->version()} Queue - {$this->queue->title}");
                }
                // 执行任务内容
                defined('WorkQueueCall') or define('WorkQueueCall', true);
                defined('WorkQueueCode') or define('WorkQueueCode', $this->code);
                if (class_exists($command = $this->queue->record['command'])) {
                    // 自定义任务，支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    $class = $this->app->make($command, [], true);
                    if ($class instanceof \think\admin\Queue) {
                        $this->update(3, $class->initialize($this->queue)->execute($this->queue->data));
                    } elseif ($class instanceof \think\admin\service\QueueService) {
                        $this->update(3, $class->initialize($this->queue->code)->execute($this->queue->data));
                    } else {
                        throw new \think\admin\Exception("自定义 {$command} 未继承 Queue 或 QueueService");
                    }
                } else {
                    // 自定义指令，不支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    $attr = explode(' ', trim(preg_replace('|\s+|', ' ', $this->queue->record['command'])));
                    $this->update(3, $this->app->console->call(array_shift($attr), $attr)->fetch(), false);
                }
            }
        } catch (\Exception|\Error $exception) {
            $code = $exception->getCode();
            if (intval($code) !== 3) $code = 4;
            $this->update($code, $exception->getMessage());
        }
    }

    /**
     * 修改当前任务状态
     * @param integer $status 任务状态
     * @param string $message 消息内容
     * @param boolean $issplit 是否分隔
     * @throws \think\db\exception\DbException
     */
    protected function update($status, $message, $issplit = true)
    {
        // 更新当前任务
        $info = trim(is_string($message) ? $message : '');
        $desc = $issplit ? explode("\n", $info) : [$message];
        $this->app->db->name($this->table)->strict(false)->where(['code' => $this->code])->update([
            'status' => $status, 'outer_time' => microtime(true), 'exec_pid' => getmypid(), 'exec_desc' => $desc[0],
        ]);
        $this->output->writeln(is_string($message) ? $message : '');
        // 任务进度标记
        if (!empty($desc[0])) {
            $this->queue->progress($status, ">>> {$desc[0]} <<<");
        }
        if ($status == 3) {
            $this->queue->progress($status, '>>> 任务处理完成 <<<', 100);
        } elseif ($status == 4) {
            $this->queue->progress($status, '>>> 任务处理失败 <<<');
        }
        // 注册循环任务
        if (isset($this->queue->record['loops_time']) && $this->queue->record['loops_time'] > 0) {
            try {
                $this->queue->initialize($this->code)->reset($this->queue->record['loops_time']);
            } catch (\Exception|\Error $exception) {
                $this->app->log->error("Queue {$this->queue->record['code']} Loops Failed. {$exception->getMessage()}");
            }
        }
    }

}
