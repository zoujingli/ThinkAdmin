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
use think\admin\service\QueueService;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

/**
 * 启动独立执行进程
 * Class WorkQueue
 * @package think\admin\command\queue
 */
class WorkQueue extends Queue
{

    /**
     * 当前任务编号
     * @var string
     */
    protected $code;

    /**
     * 当前任务数据
     * @var array
     */
    protected $queue;

    /**
     * 配置指定信息
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
            $this->queue = $this->app->db->name($this->table)->where(['code' => $this->code, 'status' => '1'])->find();
            if (empty($this->queue)) {
                // 这里不做任何处理（该任务可能在其它地方已经在执行）
                $this->output->warning($message = "The or status of task {$this->code} is abnormal");
            } else {
                // 锁定任务状态
                $this->app->db->name($this->table)->strict(false)->where(['code' => $this->code])->update([
                    'enter_time' => microtime(true), 'attempts' => $this->app->db->raw('attempts+1'),
                    'outer_time' => '0', 'exec_pid' => getmypid(), 'exec_desc' => '', 'status' => '2',
                ]);
                QueueService::instance()->progress($this->code, 2, '>>> 任务处理开始！', 0);
                // 设置进程标题
                if ($this->process->iswin()) {
                    $this->setProcessTitle("ThinkAdmin {$this->process->version()} Queue - {$this->queue['title']}");
                }
                // 执行任务内容
                defined('WorkQueueCall') or define('WorkQueueCall', true);
                defined('WorkQueueCode') or define('WorkQueueCode', $this->code);
                if (class_exists($command = $this->queue['command'])) {
                    // 自定义服务，支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    if ($command instanceof QueueService) {
                        $data = json_decode($this->queue['data'], true) ?: [];
                        $this->update('3', $command::instance()->initialize($this->code)->execute($data));
                    } else {
                        throw new \think\Exception("自定义 {$command} 未继承 QueueService");
                    }
                } else {
                    // 自定义指令，不支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    $attr = explode(' ', trim(preg_replace('|\s+|', ' ', $this->queue['command'])));
                    $this->update('3', $this->app->console->call(array_shift($attr), $attr)->fetch(), false);
                }
            }
        } catch (\Exception $exception) {
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
            QueueService::instance()->progress($this->code, $status, ">>> {$desc[0]}");
        }
        if ($status == 3) {
            QueueService::instance()->progress($this->code, $status, '>>> 任务处理完成！', 100);
        } elseif ($status == 4) {
            QueueService::instance()->progress($this->code, $status, '>>> 任务处理失败！');
        }
        // 注册循环任务
        if (isset($this->queue['loops_time']) && $this->queue['loops_time'] > 0) {
            try {
                QueueService::instance()->initialize($this->code)->reset($this->queue['loops_time']);
            } catch (\Exception $exception) {
                $this->app->log->error("Queue {$this->queue['code']} Loops Failed. {$exception->getMessage()}");
            }
        }
    }

}
