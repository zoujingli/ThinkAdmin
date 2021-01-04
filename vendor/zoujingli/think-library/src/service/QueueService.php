<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\service;

use think\admin\Exception;
use think\admin\extend\CodeExtend;
use think\admin\Service;

/**
 * 任务基础服务
 * Class QueueService
 * @package think\admin\service
 */
class QueueService extends Service
{

    /**
     * 当前任务编号
     * @var string
     */
    public $code = '';

    /**
     * 当前任务标题
     * @var string
     */
    public $title = '';

    /**
     * 当前任务参数
     * @var array
     */
    public $data = [];

    /**
     * 当前任务数据
     * @var array
     */
    public $record = [];

    /**
     * 数据初始化
     * @param integer $code
     * @return static
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function initialize($code = 0): QueueService
    {
        if (!empty($code)) {
            $this->code = $code;
            $this->record = $this->app->db->name('SystemQueue')->where(['code' => $this->code])->find();
            if (empty($this->record)) {
                $this->app->log->error("Qeueu initialize failed, Queue {$code} not found.");
                throw new \think\admin\Exception("Qeueu initialize failed, Queue {$code} not found.");
            }
            [$this->code, $this->title] = [$this->record['code'], $this->record['title']];
            $this->data = json_decode($this->record['exec_data'], true) ?: [];
        }
        return $this;
    }

    /**
     * 重发异步任务
     * @param integer $wait 等待时间
     * @return $this
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function reset($wait = 0): QueueService
    {
        if (empty($this->record)) {
            $this->app->log->error("Qeueu reset failed, Queue {$this->code} data cannot be empty!");
            throw new \think\admin\Exception("Qeueu reset failed, Queue {$this->code} data cannot be empty!");
        }
        $this->app->db->name('SystemQueue')->where(['code' => $this->code])->strict(false)->failException(true)->update([
            'exec_pid' => 0, 'exec_time' => time() + $wait, 'status' => 1,
        ]);
        return $this->initialize($this->code);
    }

    /**
     * 添加定时清理任务
     * @param integer $loops 循环时间
     * @return $this
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function addCleanQueue($loops = 3600): QueueService
    {
        return $this->register('定时清理系统任务数据', "xadmin:queue clean", 0, [], 0, $loops);
    }

    /**
     * 注册异步处理任务
     * @param string $title 任务名称
     * @param string $command 执行脚本
     * @param integer $later 延时时间
     * @param array $data 任务附加数据
     * @param integer $rscript 任务类型(0单例,1多例)
     * @param integer $loops 循环等待时间
     * @return $this
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function register(string $title, string $command, int $later = 0, array $data = [], int $rscript = 0, int $loops = 0): QueueService
    {
        $map = [['title', '=', $title], ['status', 'in', [1, 2]]];
        if (empty($rscript) && ($queue = $this->app->db->name('SystemQueue')->where($map)->find())) {
            throw new \think\admin\Exception(lang('think_library_queue_exist'), 0, $queue['code']);
        }
        $this->code = CodeExtend::uniqidDate(16, 'Q');
        $this->app->db->name('SystemQueue')->strict(false)->failException(true)->insert([
            'code'       => $this->code,
            'title'      => $title,
            'command'    => $command,
            'attempts'   => 0,
            'rscript'    => intval(boolval($rscript)),
            'exec_data'  => json_encode($data, JSON_UNESCAPED_UNICODE),
            'exec_time'  => $later > 0 ? time() + $later : time(),
            'enter_time' => 0,
            'outer_time' => 0,
            'loops_time' => $loops,
        ]);
        $this->progress(1, '>>> 任务创建成功 <<<', 0.00);
        return $this->initialize($this->code);
    }

    /**
     * 设置任务进度信息
     * @param null|integer $status 任务状态
     * @param null|string $message 进度消息
     * @param null|float $progress 进度数值
     * @param integer $backline 回退信息行
     * @return array
     */
    public function progress(?int $status = null, ?string $message = null, $progress = null, $backline = 0): array
    {
        $ckey = "queue_{$this->code}_progress";
        if (is_numeric($status) && intval($status) === 3) {
            if (!is_numeric($progress)) $progress = '100.00';
            if (is_null($message)) $message = '>>> 任务已经完成 <<<';
        }
        if (is_numeric($status) && intval($status) === 4) {
            if (!is_numeric($progress)) $progress = '0.00';
            if (is_null($message)) $message = '>>> 任务执行失败 <<<';
        }
        try {
            $data = $this->app->cache->get($ckey, [
                'code' => $this->code, 'status' => $status, 'message' => $message, 'progress' => $progress, 'history' => [],
            ]);
        } catch (\Exception | \Error $exception) {
            return $this->progress($status, $message, $progress, $backline);
        }
        while ($backline > 0 && count($data['history']) > 0) {
            [--$backline, array_pop($data['history'])];
        }
        if (is_numeric($status)) $data['status'] = intval($status);
        if (is_numeric($progress)) $progress = str_pad(sprintf("%.2f", $progress), 6, '0', STR_PAD_LEFT);
        if (is_string($message) && is_null($progress)) {
            $data['message'] = $message;
            $data['history'][] = ['message' => $message, 'progress' => $data['progress'], 'datetime' => date('Y-m-d H:i:s')];
        } elseif (is_null($message) && is_numeric($progress)) {
            $data['progress'] = $progress;
            $data['history'][] = ['message' => $data['message'], 'progress' => $progress, 'datetime' => date('Y-m-d H:i:s')];
        } elseif (is_string($message) && is_numeric($progress)) {
            $data['message'] = $message;
            $data['progress'] = $progress;
            $data['history'][] = ['message' => $message, 'progress' => $progress, 'datetime' => date('Y-m-d H:i:s')];
        }
        if (is_string($message) || is_numeric($progress)) {
            if (count($data['history']) > 10) {
                $data['history'] = array_slice($data['history'], -10);
            }
            $this->app->cache->set($ckey, $data, 86400);
        }
        return $data;
    }

    /**
     * 更新任务进度
     * @param integer $total 记录总和
     * @param integer $used 当前记录
     * @param string $message 文字描述
     * @param integer $backline 回退行数
     */
    public function message(int $total, int $used, string $message = '', $backline = 0): void
    {
        $total = $total < 1 ? 1 : $total;
        $prefix = str_pad("{$used}", strlen("{$total}"), '0', STR_PAD_LEFT);
        $message = "[{$prefix}/{$total}] {$message}";
        if (defined('WorkQueueCode')) {
            $this->progress(2, $message, sprintf("%.2f", $used / $total * 100), $backline);
        } else {
            echo $message . PHP_EOL;
        }
    }

    /**
     * 任务执行成功
     * @param string $message 消息内容
     * @throws Exception
     */
    public function success(string $message): void
    {
        throw new Exception($message, 3, $this->code);
    }

    /**
     * 任务执行失败
     * @param string $message 消息内容
     * @throws Exception
     */
    public function error(string $message): void
    {
        throw new Exception($message, 4, $this->code);
    }

    /**
     * 执行任务处理
     * @param array $data 任务参数
     * @return mixed
     */
    public function execute(array $data = [])
    {
    }

}