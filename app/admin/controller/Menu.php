<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\model\SystemMenu;
use think\admin\service\AdminService;
use think\admin\service\MenuService;
use think\admin\service\NodeService;

/**
 * 系统菜单管理
 * @class Menu
 * @package app\admin\controller
 */
class Menu extends Controller
{
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
        $this->type = $this->get['type'] ?? 'index';
        SystemMenu::mQuery()->layTable();
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        $data = DataExtend::arr2tree($data);
        // 回收站过滤有效菜单
        if ($this->type === 'recycle') foreach ($data as $k1 => &$p1) {
            if (!empty($p1['sub'])) foreach ($p1['sub'] as $k2 => &$p2) {
                if (!empty($p2['sub'])) foreach ($p2['sub'] as $k3 => $p3) {
                    if ($p3['status'] > 0) unset($p2['sub'][$k3]);
                }
                if (empty($p2['sub']) && ($p2['url'] === '#' or $p2['status'] > 0)) unset($p1['sub'][$k2]);
            }
            if (empty($p1['sub']) && ($p1['url'] === '#' or $p1['status'] > 0)) unset($data[$k1]);
        }
        // 菜单数据树数据变平化
        $data = DataExtend::arr2table($data);
        foreach ($data as &$vo) {
            if ($vo['url'] !== '#' && !preg_match('/^(https?:)?(\/\/|\\\\)/i', $vo['url'])) {
                $vo['url'] = trim(url($vo['url']) . ($vo['params'] ? "?{$vo['params']}" : ''), '\\/');
            }
        }
    }

    /**
     * 添加系统菜单
     * @auth true
     */
    public function add()
    {
        $this->_applyFormToken();
        SystemMenu::mForm('form');
    }

    /**
     * 编辑系统菜单
     * @auth true
     */
    public function edit()
    {
        $this->_applyFormToken();
        SystemMenu::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $vo
     * @throws \ReflectionException
     */
    protected function _form_filter(array &$vo)
    {
        if ($this->request->isGet()) {
            $debug = $this->app->isDebug();
            /* 清理权限节点 */
            $debug && AdminService::clear();
            /* 读取系统功能节点 */
            $this->auths = [];
            $this->nodes = MenuService::getList($debug);
            foreach (NodeService::getMethods($debug) as $node => $item) {
                if ($item['isauth'] && substr_count($node, '/') >= 2) {
                    $this->auths[] = ['node' => $node, 'title' => $item['title']];
                }
            }
            /* 选择自己上级菜单 */
            $vo['pid'] = $vo['pid'] ?? input('pid', '0');
            /* 列出可选上级菜单 */
            $menus = SystemMenu::mk()->order('sort desc,id asc')->column('id,pid,icon,url,node,title,params', 'id');
            $this->menus = DataExtend::arr2table(array_merge($menus, [['id' => '0', 'pid' => '-1', 'url' => '#', 'title' => '顶部菜单']]));
            if (isset($vo['id'])) foreach ($this->menus as $menu) if ($menu['id'] === $vo['id']) $vo = $menu;
            foreach ($this->menus as $key => $menu) if ($menu['spt'] >= 3 || $menu['url'] !== '#') unset($this->menus[$key]);
            if (isset($vo['spt']) && isset($vo['spc']) && in_array($vo['spt'], [1, 2]) && $vo['spc'] > 0) {
                foreach ($this->menus as $key => $menu) if ($vo['spt'] <= $menu['spt']) unset($this->menus[$key]);
            }
        }
    }

    /**
     * 修改菜单状态
     * @auth true
     */
    public function state()
    {
        SystemMenu::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除系统菜单
     * @auth true
     */
    public function remove()
    {
        SystemMenu::mDelete();
    }
}
