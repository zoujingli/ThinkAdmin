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

/*  测试环境禁止操作路由绑定 */
think\Route::post([
    'admin/config/index' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁修改系统配置操作！']);
    },
    'admin/config/file' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁修改文件配置操作！']);
    },
    'admin/menu/add' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁添加菜单操作！']);
    },
    'admin/menu/edit' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁编辑菜单操作！']);
    },
    'admin/menu/forbid' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁止禁用菜单操作！']);
    },
    'admin/menu/del' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁止删除菜单操作！']);
    },
    'wechat/config/index' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁止修改微信配置操作！']);
    },
    'wechat/config/pay' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁止修改微信支付操作！']);
    },
    'wechat/menu/edit' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁止修改微信菜单操作！']);
    }
]);
think\Route::get([
    'wechat/menu/cancel' => function() {
        return json(['code' => 0, 'msg' => '测试环境禁止删除微信菜单操作！']);
    }
]);

return [];
