<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\service\ProcessService;
use think\admin\service\QueueService;
use think\exception\HttpResponseException;

/**
 * 系统任务管理
 * Class Queue
 * @package app\admin\controller
 */
class Queue extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'SystemQueue';

    /**
     * 系统任务管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        if ($this->app->session->get('user.username') === 'admin') {
            try {
                $this->command = ProcessService::instance()->think('xtask:start');
                $this->message = $this->app->console->call('xtask:state')->fetch();
                $this->listen = preg_match('/process.*?\d+.*?running/', $this->message, $attr);
            } catch (\Exception $exception) {
                $this->listen = false;
                $this->message = $exception->getMessage();
            }
        }
        // 任务状态统计
        $this->total = ['dos' => 0, 'pre' => 0, 'oks' => 0, 'ers' => 0];
        $this->app->db->name($this->table)->field('status,count(1) count')->group('status')->select()->each(function ($item) {
            if ($item['status'] === 1) $this->total['pre'] = $item['count'];
            if ($item['status'] === 2) $this->total['dos'] = $item['count'];
            if ($item['status'] === 3) $this->total['oks'] = $item['count'];
            if ($item['status'] === 4) $this->total['ers'] = $item['count'];
        });
        $this->title = '系统任务管理';
        $this->iswin = ProcessService::instance()->iswin();
        // 任务列表查询分页处理
        $query = $this->_query($this->table)->dateBetween('create_at')->timeBetween('enter_time,exec_time');
        $query->like('code,title,command')->equal('status')->order('id desc')->page();
    }

    /**
     * 重启系统任务
     * @auth true
     */
    public function redo()
    {
        try {
            $data = $this->_vali(['code.require' => '任务编号不能为空！']);
            $queue = QueueService::instance()->initialize($data['code'])->reset();
            $queue->progress(1, '>>> 任务重置成功 <<<', 0.00);
            $this->success('任务重置成功！', $queue->code);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 重启任务结果处理
     * @param boolean $state
     */
    protected function _redo_save_result($state)
    {
        if ($state) {
            $this->success('重启任务成功！');
        }
    }

    /**
     * WIN创建监听进程
     * @auth true
     */
    public function start()
    {
        try {
            $message = nl2br($this->app->console->call('xtask:start')->fetch());
            if (preg_match('/process.*?\d+/', $message, $attr)) {
                $this->success('任务监听主进程启动成功！');
            } else {
                $this->error($message);
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * WIN停止监听进程
     * @auth true
     */
    public function stop()
    {
        try {
            $message = nl2br($this->app->console->call('xtask:stop')->fetch());
            if (stripos($message, 'succeeded')) {
                $this->success('停止任务监听主进程成功！');
            } elseif (stripos($message, 'finish')) {
                $this->success('没有找到需要停止的进程！');
            } else {
                $this->error($message);
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 创建记录清理任务
     * @auth true
     */
    public function clear()
    {
        try {
            QueueService::instance()->addCleanQueue();
            $this->success('创建清理任务成功！');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 删除系统任务
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
