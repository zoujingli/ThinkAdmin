<?php

// +----------------------------------------------------------------------
// | WeChatDeveloper
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

spl_autoload_register(function ($classname) {
    $filename = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
    if (file_exists($filename)) {
        if (stripos($classname, 'WeChat') === 0) include $filename;
        elseif (stripos($classname, 'WeMini') === 0) include $filename;
        elseif (stripos($classname, 'AliPay') === 0) include $filename;
        elseif (stripos($classname, 'WePay') === 0) include $filename;
        elseif ($classname === 'We') include $filename;
    }
});