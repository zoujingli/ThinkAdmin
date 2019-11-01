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

namespace think\admin;

use think\admin\extend\ProcessExtend;
use think\App;
use think\console\Input;
use think\console\Output;

/**
 * 基础任务基类
 * Class Queue
 * @package library
 */
abstract class Queue
{
    /**
     * @var App
     */
    public $app;

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
     * 当前任务内容
     * @var array
     */
    public $queue = [];

    /**
     * 判断是否WIN环境
     * @return boolean
     */
    protected function iswin()
    {
        return ProcessExtend::iswin();
    }

    /**
     * 重发异步任务
     * @param integer $wait 等待时间
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function reset($wait = 0)
    {
        if (empty($this->jobid)) return false;
        $queue = app()->db->name('SystemQueue')->where(['id' => $this->jobid])->find();
        if (empty($queue)) return false;
        $update = ['exec_time' => time() + $wait, 'attempts' => $queue['attempts'] + 1, 'status' => '1'];
        return app()->db->name('SystemQueue')->where(['id' => $this->jobid])->update($update) !== false;
    }

    /**
     * 注册异步处理任务
     * @param string $title 任务名称
     * @param string $command 执行内容
     * @param integer $later 延时执行时间
     * @param array $data 任务附加数据
     * @param integer $rscript 任务多开
     * @return boolean
     * @throws \think\Exception
     */
    public static function register($title, $command, $later = 0, $data = [], $rscript = 1)
    {
        $map = [['title', 'eq', $title], ['status', 'in', ['1', '2']]];
        if (empty($rscript) && app()->db->name('SystemQueue')->where($map)->count() > 0) {
            throw new \think\Exception('该任务已经创建，请耐心等待处理完成！');
        }
        $result = app()->db->name('SystemQueue')->insert([
            'title'      => $title,
            'command'    => $command,
            'attempts'   => '0',
            'rscript'    => intval(boolval($rscript)),
            'exec_data'  => json_encode($data, JSON_UNESCAPED_UNICODE),
            'exec_time'  => $later > 0 ? time() + $later : time(),
            'enter_time' => '0',
            'outer_time' => '0',
        ]);
        return $result !== false;
    }

    /**
     * 执行任务处理
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     * @param array $data 任务参数
     * @return mixed
     */
    abstract function execute(Input $input, Output $output, array $data = []);

}