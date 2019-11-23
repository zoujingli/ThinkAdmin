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
        $this->addArgument('splt', Argument::OPTIONAL, '指令结束符');
    }

    /**
     * 任务执行
     * @param Input $input
     * @param Output $output
     * @throws \think\db\exception\DbException
     */
    protected function execute(Input $input, Output $output)
    {
        try {
            $this->code = trim($input->getArgument('code'));
            if (empty($this->code)) throw new Exception("执行任务需要指定任务编号！");
            $queue = $this->app->db->name('SystemQueue')->where(['code' => $this->code, 'status' => '2'])->find();
            if (empty($queue)) throw new Exception("执行任务{$this->code}的信息或状态异常！");;
            // 设置进程标题
            if (($process = ProcessService::instance())->iswin()) {
                $this->setProcessTitle("ThinkAdmin {$process->version()} 执行任务 - {$queue['title']}");
            }
            // 执行任务内容
            if (class_exists($command = $queue['command'])) {
                if ($command instanceof QueueService) {
                    $data = json_decode($queue['data'], true) ?: [];
                    $this->update('3', $command::instance()->initialize($this->code)->execute($data));
                } else {
                    throw new Exception("任务处理类 {$command} 未继承 think\\admin\\service\\QueueService");
                }
            } else {
                $attr = explode(' ', trim(preg_replace('|\s+|', ' ', $queue['command'])));
                $this->update('3', $this->app->console->call(array_shift($attr), $attr, 'console'));
            }
        } catch (\Exception $e) {
            $this->update('4', $e->getMessage());
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
            'status' => $status, 'outer_time' => time(), 'exec_desc' => $desc[0],
        ]);
        $this->output->writeln(is_string($message) ? $message : '');
        return $result !== false;
    }

}
