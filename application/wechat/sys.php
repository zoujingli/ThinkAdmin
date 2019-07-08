<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

use think\Console;
use think\facade\Route;

// 注册接口路由
Route::rule('wechat/api.js', 'wechat/api.js/index');

// 注册系统指令
Console::addDefaultCommands([
    'app\wechat\command\fans\FansAll',
    'app\wechat\command\fans\FansTags',
    'app\wechat\command\fans\FansList',
    'app\wechat\command\fans\FansBlack',
]);
