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

namespace app\admin\controller;

use library\Controller;
use think\Console;
use think\Db;

/**
 * 系统消息任务管理
 * Class Queue
 * @package app\admin\controller
 */
class Queue extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'SystemJobsLog';

    /**
     * 任务列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '消息任务管理';
        $this->uris = Db::name($this->table)->distinct(true)->column('uri');
        $this->cmd = 'php ' . env('root_path') . 'think xtask:start';
        $this->message = Console::call('xtask:state')->fetch();
        $this->_query($this->table)->equal('status,title,uri')->dateBetween('create_at,status_at')->order('id desc')->page();
    }

    /**
     * 重置失败的任务
     */
    public function redo()
    {
        try {
            $where = ['id' => $this->request->post('id')];
            $info = Db::name($this->table)->where($where)->find();
            if (empty($info)) $this->error('需要重置的任务获取异常！');
            $data = isset($info['data']) ? json_decode($info['data'], true) : '[]';
            \app\admin\service\Queue::add($info['title'], $info['uri'], $info['later'], $data, $info['double'], $info['desc']);
            $this->success('任务重置成功！', url('@admin') . '#' . url('@admin/queue/index'));
        } catch (\think\exception\HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("任务重置失败，请稍候再试！<br> {$e->getMessage()}");
        }
    }

    /**
     * 删除消息任务
     */
    public function del()
    {
        try {
            $isNot = false;
            foreach (explode(',', $this->request->post('id', '0')) as $id) {
                if (!\app\admin\service\Queue::del($id)) $isNot = true;
            }
            if (empty($isNot)) $this->_delete($this->table);
            $this->success($isNot ? '部分任务删除成功！' : '任务删除成功！');
        } catch (\think\exception\HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("任务删除失败，请稍候再试！<br> {$e->getMessage()}");
        }
    }

}