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
	
    /**
     * 绑定文档操作模型
     * @var string
     */
    public $table = 'AppsDocument';
    
    public function index() {
    	$this->title = '文档列表';
    	$this->assign('categories', Db::name('AppsCategory')->column('title'));
    	parent::_list($this->table);
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
        if ($this->request->isGet()) {
        	$this->title = '添加文档';
    		$this->assign('categories', Db::name('AppsCategory')->column('id', 'title'));
        	return $this->_form($this->table, 'form');
        }
        if ($this->request->isPost()) {
        	$data = $this->request->post();
        	if (($ids = $this->_apply_document($data)) && !empty($ids)) {
        		$post = ['article_id' => $ids, 'create_by' => session('user.id')];
        		if (DataService::save($this->table, $post, 'id') !== false) {
        			$this->success('图文添加成功！', '');
        		}
        	}
        	$this->error('图文添加失败，请稍候再试！');
        }
        
    }

    /**
     * 编辑菜单
     */
    public function edit() {
        return $this->_form($this->table, 'form');
    }
    
    /**
     * 图文更新操作
     * @param array $data
     * @param array $ids
     * @return string
     */
    protected function _apply_document($data, $id=0) {
		$data['create_time'] = time();
		$data['update_time'] = time();
		$data['status'] = 1;
		
		if(empty($id)) {
			$data['uid'] = session('user.id');
			$result = $id = Db::name('AppsDocument')->insertGetId($data);
		} else {
			$result = Db::name('AppsDocument')->where('id', $id)->update($data);
		}
		if($result !== FALSE) {
			$ids[] = $id;
		}
		return $id;
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
        if (DataService::update($this->table)) {
            $this->success("菜单删除成功！", '');
        }
        $this->error("菜单删除失败，请稍候再试！");
    }

    /**
     * 菜单禁用
     */
    public function forbid() {
        if (DataService::update($this->table)) {
            $this->success("菜单禁用成功！", '');
        }
        $this->error("菜单禁用失败，请稍候再试！");
    }

    /**
     * 菜单禁用
     */
    public function resume() {
        if (DataService::update($this->table)) {
            $this->success("菜单启用成功！", '');
        }
        $this->error("菜单启用失败，请稍候再试！");
    }

}
