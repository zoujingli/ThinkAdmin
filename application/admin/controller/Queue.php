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

use app\admin\service\QueueService;
use library\Controller;
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
    protected $table = 'SystemJobsLog';

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
        if (session('admin_user.username') === 'admin') {
            try {
                $this->cmd = 'php ' . env('root_path') . 'think xtask:start';
                $this->message = Console::call('xtask:state')->fetch();
            } catch (\Exception $exception) {
                $this->message = $exception->getMessage();
            }
        }
        $this->title = '系统任务管理';
        $this->uris = Db::name($this->table)->distinct(true)->column('uri');
        // 查询任务列表
        $query = $this->_query($this->table)->dateBetween('create_at,status_at');
        $query->equal('status,title,uri')->order('id desc')->page();
    }

    /**
     * 重置失败任务
     * @auth true
     */
    public function redo()
    {
        try {
            $info = Db::name($this->table)->where(['id' => input('id', '0')])->find();
            if (empty($info)) $this->error('任务读取异常！');
            $data = isset($info['data']) ? json_decode($info['data'], true) : '[]';
            QueueService::add($info['title'], $info['uri'], $info['later'], $data, $info['double'], $info['desc']);
            $this->success('任务重置成功！', url('@admin') . '#' . url('@admin/queue/index'));
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("任务重置失败，请稍候再试！<br> {$e->getMessage()}");
        }
    }

    /**
     * 删除系统任务
     * @auth true
     */
    public function remove()
    {
        try {
            $isNot = false;
            $this->ids = explode(',', input('id', '0'));
            foreach ($this->ids as $id) if (!QueueService::del($id)) $isNot = true;
            if (empty($isNot)) $this->_delete($this->table);
            $this->success($isNot ? '部分任务删除成功！' : '任务删除成功！');
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $e) {
            $this->error("任务删除失败，请稍候再试！<br> {$e->getMessage()}");
        }
    }

}
