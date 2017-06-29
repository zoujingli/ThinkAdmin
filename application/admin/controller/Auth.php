<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use controller\BasicAdmin;
use service\DataService;
use service\NodeService;
use service\ToolsService;
use think\Db;

/**
 * 系统权限管理控制器
 * Class Auth
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:13
 */
class Auth extends BasicAdmin {

    /**
     * 默认数据模型
     * @var string
     */
    public $table = 'SystemAuth';

    /**
     * 权限列表
     */
    public function index() {
        $this->title = '系统权限管理';
        return parent::_list($this->table);
    }

    /**
     * 权限授权
     * @return string|array
     */
    public function apply() {
        $auth_id = $this->request->get('id', '0');
        switch (strtolower($this->request->get('action', '0'))) {
            case 'getnode':
                $nodes = NodeService::get();
                $checked = Db::name('SystemAuthNode')->where('auth', $auth_id)->column('node');
                foreach ($nodes as $key => &$node) {
                    $node['checked'] = in_array($node['node'], $checked);
                    if (empty($node['is_auth']) && substr_count($node['node'], '/') > 1) {
                        unset($nodes[$key]);
                    }
                }
                $this->success('获取节点成功！', '', $this->_filterNodes($this->_filterNodes(ToolsService::arr2tree($nodes, 'node', 'pnode', '_sub_'))));
                break;
            case 'save':
                $data = [];
                $post = $this->request->post();
                foreach (isset($post['nodes']) ? $post['nodes'] : [] as $node) {
                    $data[] = ['auth' => $auth_id, 'node' => $node];
                }
                Db::name('SystemAuthNode')->where('auth', $auth_id)->delete();
                Db::name('SystemAuthNode')->insertAll($data);
                $this->success('节点授权更新成功！', '');
                break;
            default :
                $this->assign('title', '节点授权');
                return $this->_form($this->table, 'apply');
        }
    }

    /**
     * 节点数据拼装
     * @param array $nodes
     * @param int $level
     * @return array
     */
    protected function _filterNodes($nodes, $level = 1) {
        foreach ($nodes as $key => &$node) {
            if (!empty($node['_sub_']) && is_array($node['_sub_'])) {
                $node['_sub_'] = $this->_filterNodes($node['_sub_'], $level + 1);
            } elseif ($level < 3) {
                unset($nodes[$key]);
            }
        }
        return $nodes;
    }

    /**
     * 权限添加
     */
    public function add() {
        return $this->_form($this->table, 'form');
    }

    /**
     * 权限编辑
     */
    public function edit() {
        return $this->_form($this->table, 'form');
    }

    /**
     * 权限禁用
     */
    public function forbid() {
        if (DataService::update($this->table)) {
            $this->success("权限禁用成功！", '');
        }
        $this->error("权限禁用失败，请稍候再试！");
    }

    /**
     * 权限恢复
     */
    public function resume() {
        if (DataService::update($this->table)) {
            $this->success("权限启用成功！", '');
        }
        $this->error("权限启用失败，请稍候再试！");
    }

    /**
     * 权限删除
     */
    public function del() {
        if (DataService::update($this->table)) {
            $id = $this->request->post('id');
            Db::name('SystemAuthNode')->where('auth', $id)->delete();
            $this->success("权限删除成功！", '');
        }
        $this->error("权限删除失败，请稍候再试！");
    }

}
