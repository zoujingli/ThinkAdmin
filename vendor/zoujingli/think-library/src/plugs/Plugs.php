<?php

namespace think\admin\plugs;

use think\admin\extend\PlugsExtend;
use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * Class Plugs
 * @package think\admin\plugs
 */
class Plugs extends Command
{
    /**
     * 指定更新模块
     * @var array
     */
    protected $modules = [];

    protected function execute(Input $input, Output $output)
    {
        $data = [];
        $extend = PlugsExtend::instance($this->app);
        $output->comment("=== 准备从代码仓库下载更新{$extend->getVersion()}版本文件 ===");
        foreach ($extend->grenerateDifference($this->modules) as $file) {
            if (in_array($file['type'], ['add', 'del', 'mod'])) {
                foreach ($this->modules as $module) {
                    if (stripos($file['name'], $module) === 0) {
                        $data[] = $file;
                    }
                }
            }
        }
        if (empty($data)) {
            $output->info('--- 本地文件与线上文件一致，无需更新文件');
        } else {
            foreach ($data as $file) {
                $this->fileSynchronization($file);
            }
        }
        $output->comment("=== 从代码仓库下载{$extend->getVersion()}版本同步更新成功 ===");
        $this->install();
    }

    private function install()
    {
        // #todo 模块安装
    }

}