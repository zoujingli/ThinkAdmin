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
     * @var QueueService
     */
    protected $queue;

    /**
     * @var ProcessService
     */
    protected $process;

    /**
     * 初始化指令变量
     * @param Input $input
     * @param Output $output
     */
    protected function initialize(Input $input, Output $output)
    {
        $this->queue = QueueService::instance();
        $this->process = ProcessService::instance();
    }

    /**
     * 设置当前任务进度
     * @param null|integer $status 任务状态
     * @param null|string $message 进度消息
     * @param null|integer $progress 进度数值
     * @return Command
     */
    protected function setQueuePropress($status = null, $message = null, $progress = null)
    {
        if (defined('WorkQueueCode')) {
            $this->queue->progress(WorkQueueCode, $status, $message, $progress);
        }
        return $this;
    }

    /**
     * 结束任务并设置状态消息
     * @param integer $status 任务状态
     * @param string $message 消息内容
     * @return Command
     * @throws Exception
     */
    protected function endQueueMessage($status, $message)
    {
        if (defined('WorkQueueCode')) {
            throw new Exception($message, $status);
        }
        return $this;
    }

}