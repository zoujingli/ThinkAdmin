<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\service\AdminService;
use think\admin\service\MenuService;
use think\admin\service\NodeService;

/**
 * 系统菜单管理
 * Class Menu
 * @package app\admin\controller
 */
class Menu extends Controller
{

    /**
     * 当前操作数据库
     * @var string
     */
    private $table = 'SystemMenu';

    /**
     * 系统菜单管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '系统菜单管理';
        $this->_page($this->table, false);
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        foreach ($data as &$vo) {
            if ($vo['url'] !== '#' && !preg_match('#^https?://#', $vo['url'])) {
                $vo['url'] = trim(url($vo['url']) . ($vo['params'] ? "?{$vo['params']}" : ''), '\\/');
            }
            $vo['ids'] = join(',', DataExtend::getArrSubIds($data, $vo['id']));
        }
        $data = DataExtend::arr2table($data);
    }

    /**
     * 添加系统菜单
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑系统菜单
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $vo
     * @throws \ReflectionException
     */
    protected function _form_filter(array &$vo)
    {
        if ($this->request->isGet()) {
            /* 清理权限节点 */
            if ($this->app->isDebug()) {
                AdminService::instance()->clearCache();
            }
            /* 选择自己的上级菜单 */
            $vo['pid'] = $vo['pid'] ?? input('pid', '0');
            /* 读取系统功能节点 */
            $this->auths = [];
            $this->nodes = MenuService::instance()->getList();
            foreach (NodeService::instance()->getMethods() as $node => $item) {
                if ($item['isauth'] && substr_count($node, '/') >= 2) {
                    $this->auths[] = ['node' => $node, 'title' => $item['title']];
                }
            }
            /* 列出可选上级菜单 */
            $menus = $this->app->db->name($this->table)->order('sort desc,id asc')->column('id,pid,icon,url,node,title,params', 'id');
            $this->menus = DataExtend::arr2table(array_merge($menus, [['id' => '0', 'pid' => '-1', 'url' => '#', 'title' => '顶部菜单']]));
            if (isset($vo['id'])) foreach ($this->menus as $menu) if ($menu['id'] === $vo['id']) $vo = $menu;
            foreach ($this->menus as $key => $menu) if ($menu['spt'] >= 3 || $menu['url'] !== '#') unset($this->menus[$key]);
            if (isset($vo['spt']) && isset($vo['spc']) && in_array($vo['spt'], [1, 2]) && $vo['spc'] > 0) {
                foreach ($this->menus as $key => $menu) if ($vo['spt'] <= $menu['spt']) unset($this->menus[$key]);
            }
        }
    }

    /**
     * 菜单编辑成功后刷新页面
     * @param bool $state
     */
    protected function _form_result(bool $state)
    {
        if ($state) {
            $this->success('系统菜单修改成功！', 'javascript:location.reload()');
        }
    }

    /**
     * 修改菜单状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_applyFormToken();
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除系统菜单
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

    /**
     * 表单结果处理
     * @param bool $result
     */
    protected function _add_form_result(bool $result)
    {
        if ($result) {
            $id = $this->app->db->name($this->table)->getLastInsID();
            sysoplog('系统菜单管理', "添加系统菜单[{$id}]成功");
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     */
    protected function _edit_form_result(bool $result)
    {
        if ($result) {
            $id = input('id') ?: 0;
            sysoplog('系统菜单管理', "修改系统菜单[{$id}]成功");
        }
    }

    /**
     * 状态结果处理
     * @param boolean $result
     */
    protected function _state_save_result(bool $result)
    {
        if ($result) {
            [$id, $state] = [input('id'), input('status')];
            sysoplog('系统菜单管理', ($state ? '激活' : '禁用') . "系统菜单[{$id}]成功");
        }
    }

    /**
     * 删除结果处理
     * @param boolean $result
     */
    protected function _remove_delete_result(bool $result)
    {
        if ($result) {
            $id = input('id') ?: 0;
            sysoplog('系统菜单管理', "删除系统菜单[{$id}]成功");
        }
    }

}
