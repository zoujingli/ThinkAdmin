<?php

// +----------------------------------------------------------------------
// | WeChatDeveloper
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

use WeChat\Contracts\BasicWeWork;

include '../include.php';

$config = include 'work-config.php';

try {
    $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=ACCESS_TOKEN';
    $result = BasicWeWork::instance($config)->callGetApi($url);
    echo '<pre>';
    print_r(BasicWeWork::instance($config)->config->get());
    print_r($result);
    echo '</pre>';
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
