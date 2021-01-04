<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\service\AdminService;
use think\admin\service\QueueService;
use think\exception\HttpResponseException;

/**
 * 后台任务通用接口
 * Class Queue
 * @package app\admin\controller\api
 */
class Queue extends Controller
{
    /**
     * 任务进度查询
     * @login true
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function progress()
    {
        $input = $this->_vali(['code.require' => '任务编号不能为空！']);
        $queue = QueueService::instance()->initialize($input['code']);
        $this->success('获取任务进度成功！', $queue->progress());
    }

    /**
     * WIN停止监听进程
     * @login true
     */
    public function stop()
    {
        try {
            $message = nl2br($this->app->console->call('xadmin:queue', ['stop'])->fetch());
            if (stripos($message, 'sent end signal to process')) {
                sysoplog('系统运维管理', '尝试停止后台服务主进程');
                $this->success('停止后台服务主进程成功！');
            } elseif (stripos($message, 'processes to stop')) {
                $this->success('没有找到需要停止的进程！');
            } else {
                $this->error($message);
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * WIN创建监听进程
     * @login true
     */
    public function start()
    {
        try {
            $message = nl2br($this->app->console->call('xadmin:queue', ['start'])->fetch());
            if (stripos($message, 'daemons started successfully for pid')) {
                sysoplog('系统运维管理', '尝试启动后台服务主进程');
                $this->success('后台服务主进程启动成功！');
            } elseif (stripos($message, 'daemons already exist for pid')) {
                $this->success('后台服务主进程已经存在！');
            } else {
                $this->error($message);
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 检查任务状态
     * @login true
     */
    public function status()
    {
        if (AdminService::instance()->isSuper()) try {
            $message = $this->app->console->call('xadmin:queue', ['status'])->fetch();
            if (preg_match('/process.*?\d+.*?running/', $message, $attrs)) {
                echo '<span class="color-green">' . $message . '</span>';
            } else {
                echo '<span class="color-red">' . $message . '</span>';
            }
        } catch (\Exception $exception) {
            echo '<span class="color-red">' . $exception->getMessage() . '</span>';
        } else {
            echo '<span class="color-red">只有超级管理员才能操作！</span>';
        }
    }
}