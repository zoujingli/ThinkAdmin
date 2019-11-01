<?php

namespace think\admin\plugs;

use think\console\Input;
use think\console\Output;

class AdminPlugs extends Plugs
{
    protected function configure()
    {
        $this->modules = ['application/admin/', 'think'];
        $this->setName('xplugs:admin')->setDescription('[同步]覆盖本地Admin模块代码');
    }

    protected function execute(Input $input, Output $output)
    {
        $this->modules[] = 'admin';
        parent::execute($input, $output);

    }

}