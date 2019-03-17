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

/**
 * 模块路由及配置检测并加载
 * @include module/init.php
 * @author Anyon<zoujingli@qq.com>
 */
foreach (scandir(env('app_path')) as $dir) {
    if ($dir[0] !== '.') {
        $filename = realpath(env('app_path') . "{$dir}/init.php");
        $filename && file_exists($filename) && include($filename);
    }
}

return [];
