<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\queue;

use think\admin\service\ProcessService;
use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 检查并创建监听主进程
 * Class StartQueue
 * @package think\admin\queue
 */
class StartQueue extends Command
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xtask:start')->setDescription('Create daemons to listening main process');
    }

    /**
     * 执行启动操作
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     */
    protected function execute(Input $input, Output $output)
    {
        $this->app->db->name('SystemQueue')->count();
        $service = ProcessService::instance();
        $command = $service->think("xtask:listen");
        if (count($result = $service->query($command)) > 0) {
            $output->info("Listening main process {$result['0']['pid']} has started");
        } else {
            $service->create($command);
            sleep(1);
            if (count($result = $service->query($command)) > 0) {
                $output->info("Listening main process {$result['0']['pid']} started successfully");
            } else {
                $output->error('Failed to create listening main process');
            }
        }
    }
}
