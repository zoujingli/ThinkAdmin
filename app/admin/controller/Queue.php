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

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\service\ProcessService;
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
            } catch (\Exception $exception) {
                $this->message = $exception->getMessage();
            }
        }
        $this->title = '系统任务管理';
        $this->iswin = PATH_SEPARATOR === ';';
        $query = $this->_query($this->table)->dateBetween('create_at');
        $query->timeBetween('enter_time,outer_time')->like('title,command');
        $query->equal('status')->order('id desc')->page();
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

    /**
     * 重启系统任务
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function redo()
    {
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 重启任务结果处理
     * @param boolean $state
     */
    protected function _redo_save_result($state)
    {
        if ($state) $this->success('重启任务成功！');
    }

    /**
     * WIN创建监听进程
     * @auth true
     */
    public function start()
    {
        try {
            $this->success(nl2br($this->app->console->call('xtask:start')->fetch()));
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
            $this->success(nl2br($this->app->console->call('xtask:stop')->fetch()));
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

}