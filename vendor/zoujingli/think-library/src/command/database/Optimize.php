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

namespace think\admin\command\database;

use think\admin\Command;
use think\console\Input;
use think\console\Output;

/**
 * 数据库优化指令
 * Class Optimize
 * @package think\admin\command
 */
class Optimize extends Command
{
    protected function configure()
    {
        $this->setName('xadmin:dbOptimize');
        $this->setDescription("Attempt to optimize all data tables");
    }

    /**
     * @param Input $input
     * @param Output $output
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function execute(Input $input, Output $output)
    {
        $tables = [];
        $this->setQueueProgress(2, "正在获取需要优化的数据表", 0);
        foreach ($this->app->db->query("show tables") as $item) {
            $tables = array_merge($tables, array_values($item));
        }
        list($total, $used) = [count($tables), 0];
        $this->setQueueProgress(2, "总共需要优化 {$total} 张数据表", 0);
        foreach ($tables as $table) {
            $stridx = str_pad(++$used, strlen("{$total}"), '0', STR_PAD_LEFT) . "/{$total}";
            $this->setQueueProgress(2, "[{$stridx}] 正在优化数据表 {$table}", $used / $total * 100);
            $this->app->db->query("OPTIMIZE TABLE `{$table}`");
        }
        $this->setQueueMessage(3, '数据库优化完成！');
    }

}