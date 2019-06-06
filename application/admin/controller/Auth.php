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
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\admin\controller;

use library\Controller;
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
        $query->like('title,desc')->equal('status')->order('sort asc,id desc')->page();
    }

    /**
     * 权限配置节点
     * @return mixed
     * @throws \ReflectionException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function apply()
    {
        $this->title = '权限配置节点';
        $auth = $this->request->post('id', '0');
        switch (strtolower($this->request->post('action'))) {
            case 'get': // 获取权限配置
                $nodes = \app\admin\service\Auth::get();
                $checked = Db::name('SystemAuthNode')->where(['auth' => $auth])->column('node');
                foreach ($nodes as &$node) $node['checked'] = in_array($node['node'], $checked);
                $data = $this->_apply_filter(\library\tools\Data::arr2tree($nodes, 'node', 'pnode', '_sub_'));
                return $this->success('获取权限节点成功！', $data);
            case 'save': // 保存权限配置
                list($post, $data) = [$this->request->post(), []];
                foreach (isset($post['nodes']) ? $post['nodes'] : [] as $node) {
                    $data[] = ['auth' => $auth, 'node' => $node];
                }
                Db::name('SystemAuthNode')->where(['auth' => $auth])->delete();
                Db::name('SystemAuthNode')->insertAll($data);
                return $this->success('权限授权更新成功！');
            default:
                return $this->_form($this->table, 'apply');
        }
    }

    /**
     * 节点数据拼装
     * @param array $nodes
     * @param integer $level
     * @return array
     */
    private function _apply_filter($nodes, $level = 1)
    {
        foreach ($nodes as $key => $node) if (!empty($node['_sub_']) && is_array($node['_sub_'])) {
            $node[$key]['_sub_'] = $this->_apply_filter($node['_sub_'], $level + 1);
        }
        return $nodes;
    }

    /**
     * 添加系统权限
     * @return array|string
     */
    public function add()
    {
        $this->applyCsrfToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑系统权限
     * @return array|string
     */
    public function edit()
    {
        $this->applyCsrfToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 禁用系统权限
     */
    public function forbid()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 启用系统权限
     */
    public function resume()
    {
        $this->applyCsrfToken();
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 删除系统权限
     */
    public function del()
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
    protected function _del_delete_result($result)
    {
        if ($result) {
            $where = ['auth' => $this->request->post('id')];
            Db::name('SystemAuthNode')->where($where)->delete();
            $this->success("权限删除成功！", '');
        } else {
            $this->error("权限删除失败，请稍候再试！");
        }
    }

}