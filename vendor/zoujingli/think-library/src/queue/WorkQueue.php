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
use think\admin\service\QueueService;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\Exception;

/**
 * 启动独立执行进程
 * Class WorkQueue
 * @package think\admin\queue
 */
class WorkQueue extends Command
{

    /**
     * 当前任务编号
     * @var integer
     */
    protected $code;

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
        $this->setName('xtask:_work')->setDescription('[执行]创建执行任务的进程');
        $this->addArgument('code', Argument::OPTIONAL, '任务编号');
        $this->addArgument('spts', Argument::OPTIONAL, '指令结束符');
    }

    /**
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     * @throws \think\db\exception\DbException
     */
    protected function execute(Input $input, Output $output)
    {
        set_time_limit(0);
        $this->code = trim($input->getArgument('code'));
        if (empty($this->code)) {
            $this->output->error('执行任务需要指定任务编号！');
        } else try {
            $queue = $this->app->db->name('SystemQueue')->where(['code' => $this->code, 'status' => '1'])->find();
            if (empty($queue)) {
                // 这里不做任何处理（该任务可能在其它地方已经在执行）
                $this->output->warning($message = "执行任务{$this->code}的或状态异常！");
            } else {
                // 锁定任务状态
                $this->app->db->name('SystemQueue')->where(['code' => $this->code])->update([
                    'status' => '2', 'enter_time' => microtime(true), 'exec_desc' => '', 'attempts' => $this->app->db->raw('attempts+1'),
                ]);
                // 设置进程标题
                if (($process = ProcessService::instance())->iswin()) {
                    $this->setProcessTitle("ThinkAdmin {$process->version()} 执行任务 - {$queue['title']}");
                }
                // 执行任务内容
                if (class_exists($command = $queue['command'])) {
                    // 自定义服务，支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    if ($command instanceof QueueService) {
                        $data = json_decode($queue['data'], true) ?: [];
                        $this->update('3', $command::instance()->initialize($this->code)->execute($data));
                    } else {
                        throw new Exception("任务处理类 {$command} 未继承 think\\admin\\service\\QueueService");
                    }
                } else {
                    // 自定义指令，不支持返回消息（支持异常结束，异常码可选择 3|4 设置任务状态）
                    $attr = explode(' ', trim(preg_replace('|\s+|', ' ', $queue['command'])));
                    $this->update('3', $this->app->console->call(array_shift($attr), $attr, 'console'));
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
     * @param integer $status 任务状态
     * @param string $message 消息内容
     * @return boolean
     * @throws \think\db\exception\DbException
     */
    protected function update($status, $message)
    {
        $desc = explode("\n", trim(is_string($message) ? $message : ''));
        $result = $this->app->db->name('SystemQueue')->where(['code' => $this->code])->update([
            'status' => $status, 'outer_time' => microtime(true), 'exec_desc' => $desc[0],
        ]);
        $this->output->writeln(is_string($message) ? $message : '');
        return $result !== false;
    }

}
