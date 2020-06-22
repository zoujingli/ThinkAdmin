<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin;

use think\admin\service\ProcessService;
use think\admin\service\QueueService;
use think\console\Command as ThinkCommand;
use think\console\Input;
use think\console\Output;

/**
 * 自定义指令基类
 * Class Command
 * @package think\admin
 */
class Command extends ThinkCommand
{
    /**
     * 任务控制服务
     * @var QueueService
     */
    protected $queue;

    /**
     * 进程控制服务
     * @var ProcessService
     */
    protected $process;

    /**
     * 初始化指令变量
     * @param Input $input
     * @param Output $output
     * @return $this
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize(Input $input, Output $output)
    {
        $this->queue = QueueService::instance();
        $this->process = ProcessService::instance();
        if (defined('WorkQueueCode')) {
            if (!$this->queue instanceof QueueService) {
                $this->queue = QueueService::instance();
            }
            if ($this->queue->code !== WorkQueueCode) {
                $this->queue->initialize(WorkQueueCode);
            }
        }
        return $this;
    }

    /**
     * 设置进度消息并继续执行
     * @param null|string $message 进度消息
     * @param null|integer $progress 进度数值
     * @return Command
     */
    protected function setQueueProgress($message = null, $progress = null)
    {
        if (defined('WorkQueueCode')) {
            $this->queue->progress(2, $message, $progress);
        } elseif (is_string($message)) {
            $this->output->writeln($message);
        }
        return $this;
    }

    /**
     * 设置失败消息并结束进程
     * @param string $message 消息内容
     * @return Command
     * @throws Exception
     */
    protected function setQueueError($message)
    {
        if (defined('WorkQueueCode')) {
            throw new Exception($message, 4, WorkQueueCode);
        } elseif (is_string($message)) {
            $this->output->writeln($message);
        }
        return $this;
    }

    /**
     * 设置成功消息并结束进程
     * @param string $message 消息内容
     * @return Command
     * @throws Exception
     */
    protected function setQueueSuccess($message)
    {
        if (defined('WorkQueueCode')) {
            throw new Exception($message, 3, WorkQueueCode);
        } elseif (is_string($message)) {
            $this->output->writeln($message);
        }
        return $this;
    }

}