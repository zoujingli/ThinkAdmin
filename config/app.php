<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2022 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

return [
    // 应用命名空间
    'app_namespace'           => '',
    // 应用快速访问
    'app_express'             => true,
    // 是否启用路由
    'with_route'              => true,
    // 超级用户账号
    'super_user'              => 'admin',
    // 默认时区
    'default_timezone'        => 'Asia/Shanghai',
    // 应用映射（自动多应用模式有效）
    'app_map'                 => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'             => [],
    // 禁止访问（自动多应用模式有效）
    'deny_app_list'           => [],
    // CORS 自动配置跨域
    'cors_auto'               => true,
    // CORS 配置跨域域名
    'cors_host'               => [],
    // CORS 授权请求方法
    'cors_methods'            => 'GET,PUT,POST,PATCH,DELETE',
    // CORS 跨域头部字段
    'cors_headers'            => 'Api-Type,Api-Name,Api-Uuid,Api-Token,User-Form-Token,User-Token,Token',
    // 显示错误的消息，仅产品模式有效
    'error_message'           => '页面错误！请稍后再试～',
    // 异常模板路径配置，仅开发模式有效
    'exception_tmpl'          => app()->getRootPath() . 'app/admin/view/error.php',
    // 异常状态模板配置，仅生产模式有效
    'http_exception_template' => [
        404 => app()->getRootPath() . 'public/static/theme/err/404.html',
        500 => app()->getRootPath() . 'public/static/theme/err/500.html',
    ],
];