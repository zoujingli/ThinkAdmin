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
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

/**
 * 清理任务历史记录
 * Class CleanQueue
 * @package think\admin\command\queue
 */
class CleanQueue extends Queue
{
    /**
     * 截止时间
     * @var integer
     */
    protected $time;

    /**
     * 配置指定信息
     */
    protected function configure()
    {
        $this->setName('xtask:clean')->setDescription('Clean up historical task records');
        $this->addArgument('time', Argument::OPTIONAL, 'BeforeTime', 7 * 24 * 3600);
    }

    /**
     * 清理历史任务
     * @param Input $input
     * @param Output $output
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DbException
     */
    protected function execute(Input $input, Output $output)
    {
        $this->time = $input->getArgument('time');
        if (empty($this->time) || !is_numeric($this->time) || $this->time <= 0) {
            $this->setQueueMessage(4, "参数错误，需要传入任务超时时间");
        } else {
            $map = [['exec_time', '<', time() - $this->time]];
            $count1 = $this->app->db->name($this->table)->where($map)->delete();
            $this->setQueueProgress(2, "清理 {$count1} 条历史任务成功", 50);
            // 重置超60分钟无响应的记录
            $map = [['exec_time', '<', time() - 3600], ['status', '=', '2']];
            $count2 = $this->app->db->name($this->table)->where($map)->update([
                'status' => '4', 'exec_desc' => '任务执行超时，已自动标识为失败！',
            ]);
            $this->setQueueProgress(2, "处理 {$count2} 条超时间任务成功", 100);
            // 返回消息到任务状态描述
            $this->setQueueMessage(3, "共清理 {$count1} 条 + 无响应 {$count2} 条");
        }
    }
}