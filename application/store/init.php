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
Route::rule('wx<_?>', function (Request $request) {
    $params = explode('-', $request->path());
    array_shift($params);
    $controller = array_shift($params) ?: config('app.default_controller');
    $action = array_shift($params) ?: config('app.default_action');
    return App::action("store/wechat.{$controller}/{$action}", $params);
});

// 微信菜单链接配置
$GLOBALS['WechatMenuLink'][] = ['link' => '@wx', 'title' => '微信商城首页'];
$GLOBALS['WechatMenuLink'][] = ['link' => '@wx-demo-jsapi', 'title' => 'JSAPI支付测试'];

// @todo 模块处理机制将写在下面（包括模块初始化及升级）
// @todo 模块权限处理，使用全局数组
// @todo 模板菜单处理，默认放到全局数组中，然后在菜单中可以快速编辑（还要考虑下）