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
use think\console\Input;
use think\console\Output;

/**
 * Class Plugs
 * @package library\command\sync
 */
class Plugs extends Sync
{
    protected function configure()
    {
        $this->modules = ['public/static/'];
        $this->setName('xsync:plugs')->setDescription('synchronize update plugs static files');
    }

    protected function execute(Input $input, Output $output)
    {
        $root = str_replace('\\', '/', env('root_path'));
        if (file_exists("{$root}/public/static/sync.lock")) {
            $this->output->error('plugs static files has been locked');
        } else {
            parent::execute($input, $output);
        }
    }
}