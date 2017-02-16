<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use library\Tools;
use think\Db;

/**
 * 后台入口
 * Class Index
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 10:41
 */
class Index extends BasicAdmin {

    /**
     * 后台框架布局
     * @return \think\response\View
     */
    public function index() {
        $list = Db::name('SystemMenu')->field('title,id,pid,url,icon')->where('status', '1')->select();
        $menus = $this->_filter_menu(Tools::arr2tree($list));
        $this->assign('title', '后台管理');
        $this->assign('menus', $menus);
        return view();
    }

    /**
     * 后台主菜单权限过滤
     * @param array $menus
     * @return array
     */
    private function _filter_menu($menus) {
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['sub'])) {
                $menu['sub'] = $this->_filter_menu($menu['sub']);
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

    /**
     * 主机信息显示
     * @return \think\response\View
     */
    public function main() {
        $version = Db::query('select version() as ver');
        $version = array_pop($version);
        $this->assign('mysql_ver', $version['ver']);
        if (session('user.username') === 'admin' && session('user.password') === '662af1cd1976f09a9f8cecc868ccc0a2') {
            $alert = [
                'type'    => 'danger',
                'title'   => '安全提示',
                'content' => '超级管理员默认密码未修改，建议马上修改！'
            ];
            $this->assign('alert', $alert);
        }
        return view();
    }

}
