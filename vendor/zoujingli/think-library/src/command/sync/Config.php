<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\command\sync;

use library\command\Sync;
use think\console\Input;
use think\console\Output;

/**
 * Class Config
 * @package library\command\sync
 */
class Config extends Sync
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->modules = ['config/'];
        $this->setName('xsync:config')->setDescription('[同步]覆盖本地Config应用配置');
    }

    /**
     * 执行更新操作
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $root = str_replace('\\', '/', env('root_path'));
        if (file_exists("{$root}/config/sync.lock")) {
            $this->output->error("--- Config 配置已经被锁定，不能继续更新");
        } else {
            parent::execute($input, $output);
        }
    }
}
