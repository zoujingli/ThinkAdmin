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

use library\Controller;
use think\Console;
use think\exception\HttpResponseException;

/**
 * 系统系统任务
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
     * 系统系统任务
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        if (session('admin_user.username') === 'admin') try {
            $this->cmd = 'php ' . env('root_path') . 'think xtask:start';
            $this->message = Console::call('xtask:state')->fetch();
        } catch (\Exception $exception) {
            $this->message = $exception->getMessage();
        }
        $this->title = '系统任务管理';
        $this->iswin = PATH_SEPARATOR === ';';
        $query = $this->_query($this->table)->dateBetween('create_at,start_at,end_at');
        $query->like('title,preload')->equal('status')->order('id desc')->page();
    }

    /**
     * 重启系统任务
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function redo()
    {
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * (WIN)创建任务监听进程
     * @auth true
     */
    public function processStart()
    {
        try {
            $this->success(nl2br(Console::call('xtask:start')->fetch()));
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * (WIN)停止任务监听进程
     * @auth true
     */
    public function processStop()
    {
        try {
            $this->success(nl2br(Console::call('xtask:stop')->fetch()));
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 删除系统任务
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
