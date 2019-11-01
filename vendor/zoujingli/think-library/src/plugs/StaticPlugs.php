<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\plugs;

/**
 * Class StaticPlugs
 * @package think\admin\plugs
 */
class StaticPlugs extends Plugs
{
    protected $rules = ['public/static'];
    protected $ignore = ['public/static/self'];

    protected function configure()
    {
        $this->setName('xplugs:static')->setDescription('[同步]覆盖本地Static插件代码');
    }
}