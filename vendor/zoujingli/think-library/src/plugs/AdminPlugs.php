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
 * Class AdminPlugs
 * @package think\admin\plugs
 */
class AdminPlugs extends Plugs
{
    /**
     * 文件规则
     * @var array
     */
    protected $rules = ['think', 'app/admin'];

    protected function configure()
    {
        $this->rules = ['application/admin/', 'think'];
        $this->setName('xplugs:admin')->setDescription('[同步]覆盖本地Admin模块代码');
    }

}