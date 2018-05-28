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
    $separator = DIRECTORY_SEPARATOR;
    $filename = __DIR__ . $separator . str_replace('\\', $separator, $classname) . '.php';
    if (file_exists($filename)) {
        if (stripos($classname, 'WeChat') === 0) {
            include $filename;
        }
        if (stripos($classname, 'WeMini') === 0) {
            include $filename;
        }
        if (stripos($classname, 'WePay') === 0) {
            include $filename;
        }
        if ($classname === 'We') {
            include $filename;
        }
    }
});