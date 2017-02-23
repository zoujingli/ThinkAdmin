<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use library\Data;
use library\Node as ModuleNode;
use library\Tools;

/**
 * 系统功能节点管理
 * Class Node
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:13
 */
class Node extends BasicAdmin {

    protected $table = 'SystemNode';

    public function index() {
        $this->title = '系统节点管理';
        parent::_list($this->table);
    }

    protected function _index_data_filter($data) {
        $nodes = [];
        $alias = [];
        foreach ($data as $vo) {
            $alias["{$vo['node']}"] = $vo;
        }
        foreach (ModuleNode::getNodeTree(APP_PATH) as $thr) {
            $tmp = explode('/', $thr);
            $one = $tmp[0];
            $two = "{$tmp[0]}/{$tmp[1]}";
            $nodes[$one] = array_merge(isset($alias[$one]) ? $alias[$one] : ['node' => $one, 'title' => $thr, 'is_menu' => 0, 'is_auth' => 0], ['pnode' => '']);
            $nodes[$two] = array_merge(isset($alias[$two]) ? $alias[$two] : ['node' => $two, 'title' => $thr, 'is_menu' => 0, 'is_auth' => 0], ['pnode' => $one]);
            $nodes[$thr] = array_merge(isset($alias[$thr]) ? $alias[$thr] : ['node' => $thr, 'title' => $thr, 'is_menu' => 1, 'is_auth' => 1], ['pnode' => $two]);
        }
        $this->assign('nodes', Tools::arr2table($nodes, 'node', 'pnode'));
    }

    public function save() {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            foreach ($post as $key => $vo) {
                if (stripos($key, 'title_') !== 0) {
                    continue;
                }
                $node = substr($key, strlen('title_'));
                $data = ['node' => $node, 'title' => $vo, 'is_menu' => intval(!empty($post["menu_{$node}"])), 'is_auth' => intval(!empty($post["auth_{$node}"]))];
                Data::save($this->table, $data, 'node');
            }
            $this->success('参数保存成功！', '');
        } else {
            $this->error('访问异常，请重新进入...');
        }
    }

}
