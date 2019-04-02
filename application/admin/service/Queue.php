<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\service;

use think\Db;

/**
 * 任务管理器
 * Class Queue
 * @package app\admin\service
 */
class Queue
{
    /**
     * 待处理
     */
    const STATUS_PEND = 1;

    /**
     * 处理中
     */
    const STATUS_PROC = 2;

    /**
     * 处理完成
     */
    const STATUS_COMP = 3;

    /**
     * 处理失败
     */
    const STATUS_FAIL = 4;

    /**
     * 创建任务并记录日志
     * @param string $title 任务名称
     * @param string $uri 任务命令
     * @param integer $later 延时时间
     * @param array $data 任务附加数据
     * @param integer $double 任务多开
     * @param string $desc 任务描述
     * @throws \think\Exception
     */
    public static function add($title, $uri, $later, array $data, $double = 1, $desc = '')
    {
        if (empty($double) && self::exists($title)) {
            throw new \think\Exception('该任务已经创建，请耐心等待处理完成！');
        }
        $jobId = Db::name('SystemJobsLog')->insertGetId([
            'title' => $title, 'later' => $later, 'uri' => $uri, 'double' => intval($double),
            'data'  => json_encode($data, 256), 'desc' => $desc, 'status_at' => date('Y-m-d H:i:s'),
        ]);
        $data['_job_id_'] = $jobId;
        $data['_job_title_'] = $title;
        \think\Queue::later($later, $uri, $data);
    }

    /**
     * 更新任务状态
     * @param integer $jobId
     * @param integer $status
     * @param string $statusDesc
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function status($jobId, $status = self::STATUS_PEND, $statusDesc = '')
    {
        $result = Db::name('SystemJobsLog')->where(['id' => $jobId])->update([
            'status' => $status, 'status_desc' => $statusDesc, 'status_at' => date('Y-m-d H:i:s'),
        ]);
        return $result !== false;
    }

    /**
     * 检查任务是否存在
     * @param string $title
     * @return boolean
     */
    public static function exists($title)
    {
        $where = [['title', 'eq', $title], ['status', 'in', [1, 2]]];
        return Db::name('SystemJobsLog')->where($where)->count() > 0;
    }

    /**
     * 获取任务数据
     * @param integer $jobId
     * @return array|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function get($jobId)
    {
        return Db::name('SystemJobsLog')->where(['id' => $jobId])->find();
    }

    /**
     * 删除任务数据
     * @param integer $jobId
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function del($jobId)
    {
        $where = [['id', 'eq', $jobId], ['status', 'in', [1, 3, 4]]];
        if (Db::name('SystemJobsLog')->where($where)->delete() > 0) {
            Db::name('SystemJobs')->whereLike('payload', '%"_job_id_":"' . $jobId . '"%')->delete();
            return true;
        }
        return false;
    }

}