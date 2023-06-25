<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\model\SystemQueue;
use think\admin\service\AdminService;
use think\admin\service\QueueService;
use think\exception\HttpResponseException;

/**
 * 任务监听服务管理
 * @class Queue
 * @package app\admin\controller\api
 */
class Queue extends Controller
{
    /**
     * 停止监听服务
     * @login true
     */
    public function stop()
    {
        if (AdminService::isSuper()) try {
            $message = $this->app->console->call('xadmin:queue', ['stop'])->fetch();
            if (stripos($message, 'sent end signal to process')) {
                sysoplog('系统运维管理', '尝试停止任务监听服务');
                $this->success('停止任务监听服务成功！');
            } elseif (stripos($message, 'processes to stop')) {
                $this->success('没有找到需要停止的服务！');
            } else {
                $this->error(nl2br($message));
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            trace_file($exception);
            $this->error($exception->getMessage());
        } else {
            $this->error('请使用超管账号操作！');
        }
    }

    /**
     * 启动监听服务
     * @login true
     */
    public function start()
    {
        if (AdminService::isSuper()) try {
            $message = $this->app->console->call('xadmin:queue', ['start'])->fetch();
            if (stripos($message, 'daemons started successfully for pid')) {
                sysoplog('系统运维管理', '尝试启动任务监听服务');
                $this->success('任务监听服务启动成功！');
            } elseif (stripos($message, 'daemons already exist for pid')) {
                $this->success('任务监听服务已经启动！');
            } else {
                $this->error(nl2br($message));
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            trace_file($exception);
            $this->error($exception->getMessage());
        } else {
            $this->error('请使用超管账号操作！');
        }
    }

    /**
     * 检查监听服务
     * @login true
     */
    public function status()
    {
        if (AdminService::isSuper()) try {
            $message = $this->app->console->call('xadmin:queue', ['status'])->fetch();
            if (preg_match('/process.*?\d+.*?running/', $message)) {
                echo "<span class='color-green pointer' data-tips-text='{$message}'>已启动</span>";
            } else {
                echo "<span class='color-red pointer' data-tips-text='{$message}'>未启动</span>";
            }
        } catch (\Error|\Exception $exception) {
            echo "<span class='color-red pointer' data-tips-text='{$exception->getMessage()}'>异 常</span>";
        } else {
            echo "<span class='color-red pointer' data-tips-text='只有超级管理员才能操作！'>无权限</span>";
        }
    }

    /**
     * 查询任务进度
     * @login true
     * @throws \think\admin\Exception
     */
    public function progress()
    {
        $input = $this->_vali(['code.require' => '任务编号不能为空！']);
        $message = SystemQueue::mk()->where($input)->value('message', '');
        if (!empty($message)) {
            $this->success('获取任务进度成功！', json_decode($message, true));
        } else {
            $queue = QueueService::instance()->initialize($input['code']);
            $this->success('获取任务进度成功！', $queue->progress());
        }
    }
}