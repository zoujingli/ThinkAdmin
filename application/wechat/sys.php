<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

// 注册系统指令
\think\Console::addDefaultCommands([
    'app\wechat\command\fans\FansAll',
    'app\wechat\command\fans\FansTags',
    'app\wechat\command\fans\FansList',
    'app\wechat\command\fans\FansBlack',
]);