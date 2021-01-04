<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\command;

use Psr\Log\NullLogger;
use think\admin\Command;
use think\Collection;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

/**
 * 异步任务管理指令
 * Class Queue
 * @package think\admin\command
 */
class Queue extends Command
{

    /**
     * 任务编号
     * @var string
     */
    protected $code;

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'SystemQueue';

    /**
     * 配置指令参数
     */
    public function configure()
    {
        $this->setName('xadmin:queue');
        $this->addOption('host', '-H', Option::VALUE_OPTIONAL, 'The host of WebServer.');
        $this->addOption('port', '-p', Option::VALUE_OPTIONAL, 'The port of WebServer.');
        $this->addOption('daemon', 'd', Option::VALUE_NONE, 'Run the queue listen in daemon mode');
        $this->addArgument('action', Argument::OPTIONAL, 'stop|start|status|query|listen|clean|dorun|webstop|webstart|webstatus', 'listen');
        $this->addArgument('code', Argument::OPTIONAL, 'Taskcode');
        $this->addArgument('spts', Argument::OPTIONAL, 'Separator');
        $this->setDescription('Asynchronous Command Queue Task for ThinkAdmin');
    }

    /**
     * 执行指令内容
     * @param Input $input
     * @param Output $output
     * @return void
     */
    public function execute(Input $input, Output $output)
    {
        $action = $this->input->hasOption('daemon') ? 'start' : $input->getArgument('action');
        if (method_exists($this, $method = "{$action}Action")) return $this->$method();
        $this->output->error(">> Wrong operation, Allow stop|start|status|query|listen|clean|dorun|webstop|webstart|webstatus");
    }

    /**
     * 停止 WebServer 调试进程
     */
    protected function webStopAction()
    {
        $root = $this->app->getRootPath() . 'public' . DIRECTORY_SEPARATOR;
        if (count($result = $this->process->query("-t {$root} {$root}router.php")) < 1) {
            $this->output->writeln(">> There are no WebServer processes to stop");
        } else foreach ($result as $item) {
            $this->process->close(intval($item['pid']));
            $this->output->writeln(">> Successfully sent end signal to process {$item['pid']}");
        }
    }

    /**
     * 启动 WebServer 调试进程
     */
    protected function webStartAction()
    {
        $port = $this->input->getOption('port') ?: '80';
        $host = $this->input->getOption('host') ?: '127.0.0.1';
        $root = $this->app->getRootPath() . 'public' . DIRECTORY_SEPARATOR;
        $command = "php -S {$host}:{$port} -t {$root} {$root}router.php";
        $this->output->comment("># {$command}");
        if (count($result = $this->process->query($command)) > 0) {
            if ($this->process->iswin()) $this->process->exec("start http://{$host}:{$port}");
            $this->output->writeln(">> WebServer process already exist for pid {$result[0]['pid']}");
        } else {
            [$this->process->create($command), usleep(2000)];
            if (count($result = $this->process->query($command)) > 0) {
                $this->output->writeln(">> WebServer process started successfully for pid {$result[0]['pid']}");
                if ($this->process->iswin()) $this->process->exec("start http://{$host}:{$port}");
            } else {
                $this->output->writeln('>> WebServer process failed to start');
            }
        }
    }

    /**
     * 查看 WebServer 调试进程
     */
    protected function webStatusAction()
    {
        $root = $this->app->getRootPath() . 'public' . DIRECTORY_SEPARATOR;
        if (count($result = $this->process->query("-t {$root} {$root}router.php")) > 0) {
            $this->output->comment("># {$result[0]['cmd']}");
            $this->output->writeln(">> WebServer process {$result[0]['pid']} running");
        } else {
            $this->output->writeln(">> The WebServer process is not running");
        }
    }

    /**
     * 停止所有任务
     */
    protected function stopAction()
    {
        $keyword = $this->process->think('xadmin:queue');
        if (count($result = $this->process->query($keyword)) < 1) {
            $this->output->writeln(">> There are no task processes to stop");
        } else foreach ($result as $item) {
            $this->process->close(intval($item['pid']));
            $this->output->writeln(">> Successfully sent end signal to process {$item['pid']}");
        }
    }

    /**
     * 启动后台任务
     */
    protected function startAction()
    {
        $this->app->db->name($this->table)->count();
        $command = $this->process->think('xadmin:queue listen');
        $this->output->comment("># {$command}");
        if (count($result = $this->process->query($command)) > 0) {
            $this->output->writeln(">> Asynchronous daemons already exist for pid {$result[0]['pid']}");
        } else {
            [$this->process->create($command), usleep(1000)];
            if (count($result = $this->process->query($command)) > 0) {
                $this->output->writeln(">> Asynchronous daemons started successfully for pid {$result[0]['pid']}");
            } else {
                $this->output->writeln(">> Asynchronous daemons failed to start");
            }
        }
    }

    /**
     * 查询所有任务
     */
    protected function queryAction()
    {
        $list = $this->process->query($this->process->think("xadmin:queue"));
        if (count($list) > 0) foreach ($list as $item) {
            $this->output->writeln(">> {$item['pid']}\t{$item['cmd']}");
        } else {
            $this->output->writeln('>> No related task process found');
        }
    }

    /**
     * 清理所有任务
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DbException
     */
    protected function cleanAction()
    {
        // 清理 7 天前的历史任务记录
        $map = [['exec_time', '<', time() - 7 * 24 * 3600]];
        $clear = $this->app->db->name($this->table)->where($map)->delete();
        // 标记超过 1 小时未完成的任务为失败状态，循环任务失败重置
        $map1 = [['loops_time', '>', 0], ['status', '=', 4]]; // 执行失败的循环任务
        $map2 = [['exec_time', '<', time() - 3600], ['status', '=', 2]]; // 执行超时的任务
        [$timeout, $loops, $total] = [0, 0, $this->app->db->name($this->table)->whereOr([$map1, $map2])->count()];
        $this->app->db->name($this->table)->whereOr([$map1, $map2])->chunk(100, function (Collection $result) use ($total, &$loops, &$timeout) {
            foreach ($result->toArray() as $item) {
                $item['loops_time'] > 0 ? $loops++ : $timeout++;
                if ($item['loops_time'] > 0) {
                    $this->queue->message($total, $timeout + $loops, "正在重置任务 {$item['code']} 为运行");
                    [$status, $message] = [1, intval($item['status']) === 4 ? '任务执行失败，已自动重置任务！' : '任务执行超时，已自动重置任务！'];
                } else {
                    $this->queue->message($total, $timeout + $loops, "正在标记任务 {$item['code']} 为超时");
                    [$status, $message] = [4, '任务执行超时，已自动标识为失败！'];
                }
                $this->app->db->name($this->table)->where(['id' => $item['id']])->update(['status' => $status, 'exec_desc' => $message]);
            }
        });
        $this->setQueueSuccess("清理 {$clear} 条历史任务，关闭 {$timeout} 条超时任务，重置 {$loops} 条循环任务");
    }

    /**
     * 查询兼听状态
     */
    protected function statusAction()
    {
        $command = $this->process->think('xadmin:queue listen');
        if (count($result = $this->process->query($command)) > 0) {
            $this->output->writeln("Listening for main process {$result[0]['pid']} running");
        } else {
            $this->output->writeln("The Listening main process is not running");
        }
    }

    /**
     * 立即监听任务
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function listenAction()
    {
        set_time_limit(0);
        $this->app->db->setLog(new NullLogger());
        $this->app->db->name($this->table)->count();
        if ($this->process->iswin()) {
            $this->setProcessTitle("ThinkAdmin {$this->process->version()} Queue Listen");
        }
        $this->output->writeln("\tYou can exit with <info>`CTRL-C`</info>");
        $this->output->writeln('============== LISTENING ==============');
        while (true) {
            [$start, $where] = [microtime(true), [['status', '=', 1], ['exec_time', '<=', time()]]];
            foreach ($this->app->db->name($this->table)->where($where)->order('exec_time asc')->cursor() as $vo) try {
                $command = $this->process->think("xadmin:queue dorun {$vo['code']} -");
                $this->output->comment("># {$command}");
                if (count($this->process->query($command)) > 0) {
                    $this->output->writeln(">> Already in progress -> [{$vo['code']}] {$vo['title']}");
                } else {
                    $this->process->create($command);
                    $this->output->writeln(">> Created new process -> [{$vo['code']}] {$vo['title']}");
                }
            } catch (\Exception $exception) {
                $this->app->db->name($this->table)->where(['code' => $vo['code']])->update([
                    'status' => 4, 'outer_time' => time(), 'exec_desc' => $exception->getMessage(),
                ]);
                $this->output->error(">> Execution failed -> [{$vo['code']}] {$vo['title']}，{$exception->getMessage()}");
            }
            if (microtime(true) < $start + 1) usleep(1000000);
        }
    }

    /**
     * 执行任务内容
     * @throws \think\db\exception\DbException
     */
    protected function doRunAction()
    {
        set_time_limit(0);
        $this->code = trim($this->input->getArgument('code'));
        if (empty($this->code)) {
            $this->output->error('Task number needs to be specified for task execution');
        } else try {
            $this->queue->initialize($this->code);
            if (empty($this->queue->record) || intval($this->queue->record['status']) !== 1) {
                // 这里不做任何处理（该任务可能在其它地方已经在执行）
                $this->output->warning("The or status of task {$this->code} is abnormal");
            } else {
                // 锁定任务状态，防止任务再次被执行
                $this->app->db->name($this->table)->strict(false)->where(['code' => $this->code])->update([
                    'enter_time' => microtime(true), 'attempts' => $this->app->db->raw('attempts+1'),
                    'outer_time' => 0, 'exec_pid' => getmypid(), 'exec_desc' => '', 'status' => 2,
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
                        $this->updateQueue(3, $class->initialize($this->queue)->execute($this->queue->data) ?: '');
                    } elseif ($class instanceof \think\admin\service\QueueService) {
                        $this->updateQueue(3, $class->initialize($this->queue->code)->execute($this->queue->data) ?: '');
                    } else {
                        throw new \think\admin\Exception("自定义 {$command} 未继承 Queue 或 QueueService");
                    }
                } else {
                    // 自定义指令，不支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    $attr = explode(' ', trim(preg_replace('|\s+|', ' ', $this->queue->record['command'])));
                    $this->updateQueue(3, $this->app->console->call(array_shift($attr), $attr)->fetch(), false);
                }
            }
        } catch (\Exception | \Error | \Throwable $exception) {
            $code = $exception->getCode();
            if (intval($code) !== 3) $code = 4;
            $this->updateQueue($code, $exception->getMessage());
        }
    }

    /**
     * 修改当前任务状态
     * @param integer $status 任务状态
     * @param string $message 消息内容
     * @param boolean $isSplit 是否分隔
     * @throws \think\db\exception\DbException
     */
    protected function updateQueue(int $status, string $message, bool $isSplit = true)
    {
        // 更新当前任务
        $info = trim(is_string($message) ? $message : '');
        $desc = $isSplit ? explode("\n", $info) : [$message];
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
            } catch (\Exception | \Error | \Throwable $exception) {
                $this->app->log->error("Queue {$this->queue->record['code']} Loops Failed. {$exception->getMessage()}");
            }
        }
    }
}