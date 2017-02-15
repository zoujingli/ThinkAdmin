<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use library\Data;
use library\Node;
use library\Tools;
use think\Db;


class Menu extends BasicAdmin {

    /**
     * 模块标题
     * @var string
     */
    public $title = '系统菜单';

    /**
     * 绑定操作模型
     * @var string
     */
    protected $table = 'SystemMenu';

    /**
     * 关闭分页
     * @var bool
     */
    protected $_page_on = false;

    /**
     * 定义菜单链接打开方式
     * @var array
     */
    protected $targetList = array(
        '_self'   => '本窗口打开',
        '_blank'  => '新窗口打开',
        '_parent' => '父窗口打开',
        '_top'    => '顶级窗口打开',
    );

    /**
     * 菜单列表
     */
    public function index() {
        $db = Db::name($this->table);
        parent::_list($db, false);
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
     * 新增编辑方法
     */
    public function form() {
        // 读取节点列表
        if ($this->request->isGet() && $this->request->get('action') === 'nodelist') {
            $list = Db::name("SystemNode")->where(["status" => 1, "is_menu" => 1])->order("module asc,controller asc")->select();
            $new_data = [];
            foreach ($list as $value) {
                if (empty($value['pnode'])) {
                    //主节点
                    $new_data[$value['module']]['node'] = $value['module'];
                    $new_data[$value['module']]['title'] = $value['menu_desc'];
                } elseif (substr_count($value['pnode'], ' / ') == 0) {
                    //二级节点
                    $new_data[$value['module']]["_sub_"][$value['controller']]["node"] = $value['pnode'];
                    $new_data[$value['module']]["_sub_"][$value['controller']]["title"] = $value['menu_desc'];
                } else {
                    //三级节点
                    $new_data[$value['module']]["_sub_"][$value['controller']]["_sub_"][$value['method']] = array("node" => $value['node'], "title" => $value['menu_desc']);
                }
            }
            return $new_data;
        }
        // 表单操作
        $db = Db::name($this->table);
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!isset($post['id'])) {
                if ($db->insert($post)) {
                    $this->success("数据保存成功", '');
                } else {
                    $this->error("数据保存失败");
                }
            } else {
                Data::save($db, $post);
                $this->success("数据保存成功");
            }
        } else {
            $id = $this->request->get('id');
            $vo = $db->where(["id" => $id, 'status' => 1])->find();
            $this->assign("vo", $vo);
            /* 去除自己的菜单及子菜单 */
            $_menus = Db::name($this->table)->where('status', '1')->order('sort ASC,id ASC')->select();
            $menus = Tools::arr2table($_menus);
            foreach ($menus as $key => &$menu) {
                $current_path = "-{$vo['pid']}-{$vo['id']}";
                if ($vo['pid'] !== '' && (stripos("{$menu['path']}-", "{$current_path}-") !== false || $menu['path'] === $current_path)) {
                    unset($menus[$key]);
                }
            }
            $this->assign('menus', $menus);
            //节点列表
            $db = Db::name("SystemNode")->field('node,is_menu,menu_desc')->where('is_menu', '1')->order('node ASC');
            $nodes = parent::_list($db, false, false);
            $this->assign('nodes', $nodes['list']);
            $this->assign("title", "编辑菜单");
            return $this->fetch();
        }
    }

    /**
     * 表单数据
     */
    protected function _form_filter() {
        if ($this->request->isGet()) {
            //节点列表
            $db = Db::name("SystemNode")->field('node,is_menu,menu_desc')->where('is_menu', '1')->order('node ASC');
            $nodes = parent::_list($db, false, false);
            $this->assign('nodes', $nodes['list']);
        }
    }


    /**
     * 添加菜单
     */
    public function add() {
        return $this->_form($this->table);
    }

    /**
     * 编辑菜单
     */
    public function edit() {
        return $this->_form($this->table);
    }

    /**
     * 删除菜单
     */
    public function del() {
        if (Data::update($this->table)) {
            $this->success("菜单删除成功！");
        } else {
            $this->error("菜单删除失败，请稍候再试！");
        }
    }

    /**
     * 菜单禁用
     */
    public function forbid() {
        if (Data::update($this->table)) {
            $this->success("菜单禁用成功！");
        } else {
            $this->error("菜单禁用失败，请稍候再试！");
        }
    }

    /**
     * 菜单禁用
     */
    public function resume() {
        if (Data::update($this->table)) {
            $this->success("菜单启用成功！");
        } else {
            $this->error("菜单启用失败，请稍候再试！");
        }
    }

    /**
     * 读取菜单节点数据
     * @return array
     */
    private function _getMenuNodeData() {
        $list = Node::getNodeArrayTree(implode(",", Node::getDir(APP_PATH)));
        unset($list['Admin']['Public'], $list['Admin']['Index']);
        //只识别菜单属性的节点
        foreach ($list as $key => $module) {
            foreach ($module as $_key => $action) {
                foreach ($action as $__key => $method) {
                    if (!isset($method['menu']) || !is_array($method['menu']) || empty($method['menu']['status'])) {
                        unset($list[$key][$_key][$__key]);
                    }
                }
            }
        }
        return $list;
    }

}
