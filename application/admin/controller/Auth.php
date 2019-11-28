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
use library\service\AdminService;
use think\Db;

/**
 * 系统权限管理
 * Class Auth
 * @package app\admin\controller
 */
class Auth extends Controller
{
    /**
     * 默认数据模型
     * @var string
     */
    public $table = 'SystemAuth';

    /**
     * 系统权限管理
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
        $this->title = '系统权限管理';
        $query = $this->_query($this->table)->dateBetween('create_at');
        $query->like('title,desc')->equal('status')->order('sort desc,id desc')->page();
    }

    /**
     * 权限配置节点
     * @auth true
     * @throws \ReflectionException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function apply()
    {
        $map = ['auth' => input('id', '0')];
        $action = strtolower(input('action', ''));
        if ($action === 'get') {
            $checkeds = Db::name('SystemAuthNode')->where($map)->column('node');
            $this->success('获取权限节点成功！', AdminService::instance()->getTree($checkeds));
        } elseif ($action === 'save') {
            list($post, $data) = [$this->request->post(), []];
            foreach (isset($post['nodes']) ? $post['nodes'] : [] as $node) {
                $data[] = ['auth' => $map['auth'], 'node' => $node];
            }
            Db::name('SystemAuthNode')->where($map)->delete();
            Db::name('SystemAuthNode')->insertAll($data);
            AdminService::instance()->apply(true);
            $this->success('权限授权更新成功！', 'javascript:history.back()');
        } else {
            $this->title = '权限配置节点';
            $this->_form($this->table, 'apply');
        }
    }

    /**
     * 添加系统权限
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        $this->applyCsrfToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑系统权限
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit()
    {
        $this->applyCsrfToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 刷新系统权限
     * @auth true
     */
    public function refresh()
    {
        try {
            AdminService::instance()->apply(true);
            $this->success('刷新系统授权成功！');
        } catch (\think\exception\HttpResponseException $exception) {
            throw  $exception;
        } catch (\Exception $e) {
            $this->error("刷新系统授权失败<br>{$e->getMessage()}");
        }
    }

    /**
     * 禁用系统权限
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 启用系统权限
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 删除系统权限
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->applyCsrfToken();
        $this->_delete($this->table);
    }

    /**
     * 删除结果处理
     * @param boolean $result
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function _remove_delete_result($result)
    {
        if ($result) {
            $map = ['auth' => $this->request->post('id')];
            Db::name('SystemAuthNode')->where($map)->delete();
            $this->success("权限删除成功！", '');
        } else {
            $this->error("权限删除失败，请稍候再试！");
        }
    }

}
