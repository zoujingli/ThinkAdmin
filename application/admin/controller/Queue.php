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
use library\service\ProcessService;
use think\Console;
use think\Db;
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
        if (session('user.username') === 'admin') try {
            $this->message = Console::call('xtask:state')->fetch();
            $this->command = ProcessService::instance()->think('xtask:start');
            $this->listen = preg_match('/process.*?\d+.*?running/', $this->message, $attr);
        } catch (\Exception $exception) {
            $this->listen = false;
            $this->message = $exception->getMessage();
        }
        $this->title = '系统任务管理';
        $this->iswin = ProcessService::instance()->iswin();
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
     * WIN开始监听任务
     * @auth true
     */
    public function start()
    {
        try {
            $message = nl2br(Console::call('xtask:start')->fetch());
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
     * WIN停止监听任务
     * @auth true
     */
    public function stop()
    {
        try {
            $message = nl2br(Console::call('xtask:stop')->fetch());
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
     * 清理3天前的记录
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function clear()
    {
        $map = [['time', '<', strtotime('-3days')]];
        $result = Db::name($this->table)->where($map)->delete();
        if ($result !== false) {
            $this->success('成功清理3天前的任务记录！');
        } else {
            $this->error('清理3天前的任务记录失败！');
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
