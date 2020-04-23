<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\command;

use think\admin\service\ProcessService;
use think\App;
use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 获取框架版本号
 * Class Version
 * @package think\admin\command
 */
class Version extends Command
{
    protected function configure()
    {
        $this->setName('xadmin:version');
        $this->setDescription("Query application framework version");
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln('ThinkLib ' . ProcessService::instance()->version());
        $output->writeln('ThinkPHP ' . App::VERSION);
    }
}