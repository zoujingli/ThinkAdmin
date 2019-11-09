<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

/*  演示环境禁止操作路由绑定 */
if (in_array(request()->rootDomain(), ['ctolog.com', 'thinkadmin.top'])) {
    $app = app();
    $app->route->post('admin/user/pass', function () {
        return json(['code' => 0, 'info' => '演示环境禁止修改用户密码！']);
    });
    $app->route->post('admin/index/pass', function () {
        return json(['code' => 0, 'info' => '演示环境禁止修改用户密码！']);
    });
    $app->route->post('admin/config/config', function () {
        return json(['code' => 0, 'info' => '演示环境禁止修改系统配置！']);
    });
    $app->route->post('admin/config/storage', function () {
        return json(['code' => 0, 'info' => '演示环境禁止修改系统配置！']);
    });
    $app->route->post('admin/menu/index', function () {
        return json(['code' => 0, 'info' => '演示环境禁止给菜单排序！']);
    });
    $app->route->post('admin/menu/add', function () {
        return json(['code' => 0, 'info' => '演示环境禁止添加菜单！']);
    });
    $app->route->post('admin/menu/edit', function () {
        return json(['code' => 0, 'info' => '演示环境禁止编辑菜单！']);
    });
    $app->route->post('admin/menu/state', function () {
        return json(['code' => 0, 'info' => '演示环境禁止禁用菜单！']);
    });
    $app->route->post('admin/menu/remove', function () {
        return json(['code' => 0, 'info' => '演示环境禁止删除菜单！']);
    });
}
