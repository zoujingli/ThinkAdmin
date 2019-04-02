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
 * 系统模块更新指令
 * Class UpdateAdmin
 * @package app\admin\logic\update
 */
class Admin extends Sync
{
    protected function configure()
    {
        $this->modules = ['application/admin/', 'think'];
        $this->setName('xsync:admin')->setDescription('synchronize update admin module files');
    }
}