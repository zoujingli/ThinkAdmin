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