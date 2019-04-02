<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\command\sync;

use library\command\Sync;

/**
 * 更新微信模块指令
 * Class UpdateWechat
 * @package app\admin\logic\update
 */
class Wechat extends Sync
{
    protected function configure()
    {
        $this->modules = ['application/wechat/'];
        $this->setName('xsync:wechat')->setDescription('synchronize update wechat module files');
    }
}