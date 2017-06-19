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
 * 文档管理
 * Class Menu
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15
 */
class Document extends BasicAdmin {
	
	public $document_table = 'AppsDocument';

    /**
     * 绑定分类操作模型
     * @var string
     */
    public $category_table = 'AppsCategory';
    
    public function index() {
    	$this->title = '文档列表';
    	$this->assign('categories', Db::name($this->category_table)->column('title'));
    	parent::_list($this->document_table);
    }

    /**
     * 菜单列表
     */
    public function category() {
        $this->title = '文档分类管理';
        $db = Db::name($this->category_table)->order('sort asc,id asc');
        parent::_list($db, false);
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _category_data_filter(&$data) {
        foreach ($data as &$vo) {
            ($vo['url'] !== '#') && ($vo['url'] = url($vo['url']));
            $vo['ids'] = join(',', ToolsService::getArrSubIds($data, $vo['id']));
        }
        $data = ToolsService::arr2table($data);
    }

    /**
     * 添加菜单
     */
    public function add() {
    	$this->title = '添加文档';
    	$this->assign('categories', Db::name($this->category_table)->column('title'));
        return $this->_form($this->document_table, 'form');
    }

    /**
     * 编辑菜单
     */
    public function edit() {
        return $this->_form($this->category_table, 'form');
    }

    /**
     * 表单数据前缀方法
     * @param array $vo
     */
    protected function _form_filter(&$vo) {
        if ($this->request->isGet()) {
            // 上级菜单处理
            $_menus = Db::name($this->category_table)->where('status', '1')->order('sort desc,id desc')->select();
            $_menus[] = ['title' => '顶级菜单', 'id' => '0', 'pid' => '-1'];
            $menus = ToolsService::arr2table($_menus);
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
            $nodes = NodeService::get();
            foreach ($nodes as $key => $_vo) {
                if (empty($_vo['is_menu'])) {
                    unset($nodes[$key]);
                }
            }
            $this->assign('nodes', array_column($nodes, 'node'));
            $this->assign('menus', $menus);
        }
    }

    /**
     * 删除菜单
     */
    public function del() {
        if (DataService::update($this->category_table)) {
            $this->success("菜单删除成功！", '');
        }
        $this->error("菜单删除失败，请稍候再试！");
    }

    /**
     * 菜单禁用
     */
    public function forbid() {
        if (DataService::update($this->category_table)) {
            $this->success("菜单禁用成功！", '');
        }
        $this->error("菜单禁用失败，请稍候再试！");
    }

    /**
     * 菜单禁用
     */
    public function resume() {
        if (DataService::update($this->category_table)) {
            $this->success("菜单启用成功！", '');
        }
        $this->error("菜单启用失败，请稍候再试！");
    }

}
