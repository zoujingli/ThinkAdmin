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

namespace library\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 清理会话文件
 * Class Sess
 * @package library\command
 */
class Sess extends Command
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xclean:session')->setDescription('Clean up invalid session files');
    }

    /**
     * 执行清理操作
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $output->comment('Start cleaning up invalid session files');
        foreach (glob(config('session.path') . 'sess_*') as $file) {
            list($fileatime, $filesize) = [fileatime($file), filesize($file)];
            if ($filesize < 1 || $fileatime < time() - 3600) {
                $output->info('Remove session file -> [ ' . date('Y-m-d H:i:s', $fileatime) . ' ] ' . basename($file) . " {$filesize}");
                @unlink($file);
            }
        }
        $output->comment('Cleaning up invalid session files complete');
    }

}
