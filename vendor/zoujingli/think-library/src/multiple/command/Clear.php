<?php

// 以下代码来自 topthink/think-multi-app，有部分修改以兼容 ThinkAdmin 的需求
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\multiple\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Clear extends Command
{
    protected function configure()
    {
        $this->setName('clear')->addArgument('app', Argument::OPTIONAL, 'app name .');
        $this->addOption('cache', 'c', Option::VALUE_NONE, 'clear cache file');
        $this->addOption('log', 'l', Option::VALUE_NONE, 'clear log file');
        $this->addOption('dir', 'r', Option::VALUE_NONE, 'clear empty dir');
        $this->setDescription('Clear runtime file');
    }

    protected function execute(Input $input, Output $output)
    {
        $app = $input->getArgument('app') ?: '';
        $runtimePath = $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . ($app ? $app . DIRECTORY_SEPARATOR : '');
        if ($input->getOption('cache')) {
            $path = $runtimePath . 'cache';
        } elseif ($input->getOption('log')) {
            $path = $runtimePath . 'log';
        } else {
            $path = $runtimePath;
        }
        $rmdir = $input->getOption('dir') ? true : false;
        $this->clear(rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR, $rmdir);
        $output->writeln("<info>Clear Successed</info>");
    }

    protected function clear(string $path, bool $rmdir): void
    {
        $files = is_dir($path) ? scandir($path) : [];
        foreach ($files as $file) {
            if ('.' != $file && '..' != $file && is_dir($path . $file)) {
                array_map('unlink', glob($path . $file . DIRECTORY_SEPARATOR . '*.*'));
                if ($rmdir) rmdir($path . $file);
            } elseif ('.gitignore' != $file && is_file($path . $file)) {
                unlink($path . $file);
            }
        }
    }
}
