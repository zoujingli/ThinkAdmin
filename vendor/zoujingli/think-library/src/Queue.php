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

use think\admin\service\ProcessService;
use think\App;
use think\console\Input;
use think\console\Output;

/**
 * 基础任务基类
 * Class Queue
 * @package think\admin
 */
class Queue
{
    /**
     * 应用实例
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
     * Queue constructor.
     * @param App $app
     * @param int $jobid
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function __construct(App $app, $jobid = 0)
    {
        $this->app = $app;
        if ($jobid > 0) $this->init($jobid);
    }

    /**
     * 静态获取实例
     * @param App $app
     * @param int $jobid
     * @return static
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function instance(App $app, $jobid = 0)
    {
        return new static($app, $jobid);
    }

    /**
     * 数据初始化
     * @param integer $jobid
     * @return Queue
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function init($jobid = 0)
    {
        if ($jobid > 0) {
            $this->queue = $this->app->db->name('SystemQueue')->where(['id' => $this->jobid])->find();
            if (empty($this->queue)) throw new \think\Exception("Queue {$jobid} Not found.");
            $this->title = $this->queue['title'];
        }
        return $this;
    }

    /**
     * 判断是否WIN环境
     * @return boolean
     */
    protected function iswin()
    {
        return ProcessService::instance($this->app)->iswin();
    }

    /**
     * 重发异步任务
     * @param integer $wait 等待时间
     * @return Queue
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function reset($wait = 0)
    {
        if (empty($this->queue)) throw new \think\Exception('Queue data cannot be empty!');
        $this->app->db->name('SystemQueue')->where(['id' => $this->jobid])->failException(true)->update([
            'exec_time' => time() + $wait, 'attempts' => $this->queue['attempts'] + 1, 'status' => '1',
        ]);
        return $this->init($this->jobid);
    }

    /**
     * 注册异步处理任务
     * @param string $title 任务名称
     * @param string $command 执行内容
     * @param integer $later 延时执行时间
     * @param array $data 任务附加数据
     * @param integer $rscript 任务多开
     * @return Queue
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function register($title, $command, $later = 0, $data = [], $rscript = 1)
    {
        $map = [['title', 'eq', $title], ['status', 'in', ['1', '2']]];
        if (empty($rscript) && $this->app->db->name('SystemQueue')->where($map)->count() > 0) {
            throw new \think\Exception('该任务已经创建，请耐心等待处理完成！');
        }
        $this->jobid = $this->app->db->name('SystemQueue')->failException(true)->insertGetId([
            'title'      => $title,
            'command'    => $command,
            'attempts'   => '0',
            'rscript'    => intval(boolval($rscript)),
            'exec_data'  => json_encode($data, JSON_UNESCAPED_UNICODE),
            'exec_time'  => $later > 0 ? time() + $later : time(),
            'enter_time' => '0',
            'outer_time' => '0',
        ]);
        return $this->init($this->jobid);
    }

    /**
     * 执行任务处理
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     * @param array $data 任务参数
     * @return mixed
     */
    public function execute(Input $input, Output $output, array $data = [])
    {
    }

}