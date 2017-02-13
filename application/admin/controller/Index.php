<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use library\Tools;
use think\Db;

class Index extends BasicAdmin {

    public function index() {
        $this->assign('ptitle', '后台管理');
        $menuList = Db::name('SystemMenu')->field('title,id,pid,url,icon')->where('status', '1')->select();
        $result = Tools::arr2tree($menuList);
        $this->assign('menus', $this->_filterMenu($result));
        return view();
    }

    /**
     * 后台主菜单权限过滤
     * --- 权限只检测节点三级
     * @param array $menus
     * @return array
     */
    private function _filterMenu($menus) {
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['sub'])) {
                $menu['sub'] = $this->_filterMenu($menu['sub']);
            }
            if (!empty($menu['sub'])) {
                $menu['url'] = '#';
            } elseif (stripos($menu['url'], 'http') === 0) {
                continue;
            } elseif ($menu['url'] !== '#' && auth(join('/', array_slice(explode('/', $menu['url']), 0, 3)))) {
                $menu['url'] = url($menu['url']);
            } else {
                unset($menus[$key]);
            }
        }
        return $menus;
    }

    public function main() {
        $version = Db::query('select version() as ver');
        $version = array_pop($version);
        $this->assign('mysql_ver', $version['ver']);
        return view();
    }

}