<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

use think\facade\Route;

return [];

/*  测试环境禁止操作路由绑定 */
Route::post('admin/user/pass', function () {
    return json(['code' => 0, 'info' => '测试环境禁修改用户密码！']);
});
Route::post('admin/index/pass', function () {
    return json(['code' => 0, 'info' => '测试环境禁修改用户密码！']);
});
Route::post('admin/config/info', function () {
    return json(['code' => 0, 'info' => '测试环境禁修改系统配置操作！']);
});
Route::post('admin/config/file', function () {
    return json(['code' => 0, 'info' => '测试环境禁修改文件配置操作！']);
});
Route::post('admin/menu/index', function () {
    return json(['code' => 0, 'info' => '测试环境禁排序菜单操作！']);
});
Route::post('admin/menu/add', function () {
    return json(['code' => 0, 'info' => '测试环境禁添加菜单操作！']);
});
Route::post('admin/menu/edit', function () {
    return json(['code' => 0, 'info' => '测试环境禁编辑菜单操作！']);
});
Route::post('admin/menu/forbid', function () {
    return json(['code' => 0, 'info' => '测试环境禁止禁用菜单操作！']);
});
Route::post('admin/menu/del', function () {
    return json(['code' => 0, 'info' => '测试环境禁止删除菜单操作！']);
});
Route::post('admin/node/save', function () {
    return json(['code' => 0, 'info' => '测试环境禁止修改节点数据操作！']);
});
Route::post('wechat/config/index', function () {
    return json(['code' => 0, 'info' => '测试环境禁止修改微信配置操作！']);
});
Route::post('wechat/config/options', function () {
    return json(['code' => 0, 'info' => '测试环境禁止修改微信配置操作！']);
});
Route::post('service/config/index', function () {
    return json(['code' => 0, 'info' => '测试环境禁止修改微信配置操作！']);
});
