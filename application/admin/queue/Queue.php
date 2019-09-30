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

namespace app\admin\queue;

use think\console\Input;
use think\console\Output;
use think\Db;

/**
 * 异步任务基类
 * Class Queue
 * @package app\admin\queue
 */
abstract class Queue
{
    /**
     * 当前任务ID
     * @var integer
     */
    public $jobid = 0;

    /**
     * 当前任务标题
     * @var string
     */
    public $title = '';

    /**
     * 判断是否WIN环境
     * @return boolean
     */
    protected function isWin()
    {
        return PATH_SEPARATOR === ';';
    }

    /**
     * 重发异步任务记录
     * @param integer $wait 等待时间
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function redo($wait = 0)
    {
        if ($this->jobid > 0) {
            if ($queue = Db::name('SystemQueue')->where(['id' => $this->jobid])->find()) {
                $queue['time'] = time() + $wait;
                $queue['title'] .= " - 来自任务{$this->jobid} 重发任务";
                unset($queue['id'], $queue['create_at'], $queue['desc']);
                return Db::name('SystemQueue')->insert($queue) !== false;
            }
        }
        return false;
    }

    /**
     * 执行异步任务
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     * @param array $data 任务参数
     * @return mixed
     */
    abstract function execute(Input $input, Output $output, array $data = []);
}