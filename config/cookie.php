<?php

// +----------------------------------------------------------------------
// | Static Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon<zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-static
// +----------------------------------------------------------------------

return [
    // cookie 保存时间
    'expire'    => 0,
    // cookie 保存路径
    'path'      => '/',
    // cookie 有效域名
    'domain'    => '',
    // httponly 访问设置
    'httponly'  => true,
    // 是否使用 setcookie
    'setcookie' => true,
    // cookie 安全传输，只支持 https 协议
    'secure'    => request()->isSsl(),
    // samesite 安全设置，支持 'strict' 'lax' 'none'
    'samesite'  => request()->isSsl() ? 'none' : 'lax',
];
