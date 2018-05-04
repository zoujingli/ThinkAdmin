<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

use think\facade\App;
use think\facade\Route;
use think\Request;

/* 注册微信端路由支持 */
Route::rule('wx-<controller>-<action>', function (Request $request, $controller, $action) {
    $params = explode('-', $request->pathinfo());
    [array_shift($params), array_shift($params), array_shift($params)];
    return App::action("store/wechat.{$controller}/{$action}", $params);
});

return [];

/*  测试环境禁止操作路由绑定 */
Route::post('admin/user/pass', function () {
    return json(['code' => 0, 'msg' => '测试环境禁修改用户密码！']);
});
Route::post('admin/index/pass', function () {
    return json(['code' => 0, 'msg' => '测试环境禁修改用户密码！']);
});
Route::post('admin/config/index', function () {
    return json(['code' => 0, 'msg' => '测试环境禁修改系统配置操作！']);
});
Route::post('admin/config/file', function () {
    return json(['code' => 0, 'msg' => '测试环境禁修改文件配置操作！']);
});
Route::post('admin/menu/index', function () {
    return json(['code' => 0, 'msg' => '测试环境禁排序菜单操作！']);
});
Route::post('admin/menu/add', function () {
    return json(['code' => 0, 'msg' => '测试环境禁添加菜单操作！']);
});
Route::post('admin/menu/edit', function () {
    return json(['code' => 0, 'msg' => '测试环境禁编辑菜单操作！']);
});
Route::post('admin/menu/forbid', function () {
    return json(['code' => 0, 'msg' => '测试环境禁止禁用菜单操作！']);
});
Route::post('admin/menu/del', function () {
    return json(['code' => 0, 'msg' => '测试环境禁止删除菜单操作！']);
});
Route::post('wechat/config/index', function () {
    return json(['code' => 0, 'msg' => '测试环境禁止修改微信配置操作！']);
});
Route::post('admin/node/save', function () {
    return json(['code' => 0, 'msg' => '测试环境禁止修改节点数据操作！']);
});
Route::post('wechat/menu/edit', function () {
    return json(['code' => 0, 'msg' => '测试环境禁止修改微信菜单操作！']);
});
Route::get('wechat/menu/cancel', function () {
    return json(['code' => 0, 'msg' => '测试环境禁止删除微信菜单操作！']);
});
