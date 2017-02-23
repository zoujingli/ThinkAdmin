<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use library\Data;
use library\Node;
use library\Tools;
use think\Db;

/**
 * 系统后台管理管理
 * Class Menu
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15
 */
class Menu extends BasicAdmin {

    /**
     * 绑定操作模型
     * @var string
     */
    protected $table = 'SystemMenu';

    /**
     * 菜单列表
     */
    public function index() {
        $this->title = '系统菜单管理';
        parent::_list($this->table, false);
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_data_filter(&$data) {
        foreach ($data as &$vo) {
            ($vo['url'] !== '#') && ($vo['url'] = url($vo['url']));
            $vo['ids'] = join(',', Tools::getArrSubIds($data, $vo['id']));
        }
        $data = Tools::arr2table($data);
    }

    /**
     * 添加菜单
     */
    public function add() {
        if ($this->request->isPost()) {
            $this->error('系统开发中，不要动菜单哦！');
        }
        return $this->_form($this->table, 'form');
    }

    /**
     * 编辑菜单
     */
    public function edit() {
        return $this->add();
    }

    /**
     * 表单数据前缀方法
     * @param array $vo
     */
    protected function _form_filter(&$vo) {
        if ($this->request->isGet()) {
            // 上级菜单处理
            $_menus = Db::name($this->table)->where('status', '1')->order('sort desc,id desc')->select();
            $_menus[] = ['title' => '顶级菜单', 'id' => '0', 'pid' => '-1'];
            $menus = Tools::arr2table($_menus);
            foreach ($menus as $key => &$menu) {
                if (substr_count($menu['path'], '-') > 3) {
                    unset($menus[$key]);
                    continue;
                }
                if (isset($vo['pid'])) {
                    $current_path = "-{$vo['pid']}-{$vo['id']}";
                    if ($vo['pid'] !== '' && (stripos("{$menu['path']}-", "{$current_path}-") !== false || $menu['path'] === $current_path)) {
                        unset($menus[$key]);
                    }
                }
            }
            // 读取系统功能节点
            $nodes = Node::getNodeTree(APP_PATH);
            $denyAll = Db::name('SystemNode')->where('is_menu', '0')->column('node');
            foreach ($nodes as $key => $vo) {
                if (in_array($vo, $denyAll)) {
                    unset($nodes[$key]);
                }
            }
            $this->assign('nodes', array_values($nodes));
            $this->assign('menus', $menus);
        }
    }

    /**
     * 删除菜单
     */
    public function del() {
        $this->error('别再删我菜单了...');
        if (Data::update($this->table)) {
            $this->success("菜单删除成功！", '');
        } else {
            $this->error("菜单删除失败，请稍候再试！");
        }
    }

    /**
     * 菜单禁用
     */
    public function forbid() {
        $this->error('请不要禁用菜单...');
        if (Data::update($this->table)) {
            $this->success("菜单禁用成功！", '');
        } else {
            $this->error("菜单禁用失败，请稍候再试！");
        }
    }

    /**
     * 菜单禁用
     */
    public function resume() {
        if (Data::update($this->table)) {
            $this->success("菜单启用成功！", '');
        } else {
            $this->error("菜单启用失败，请稍候再试！");
        }
    }

}
