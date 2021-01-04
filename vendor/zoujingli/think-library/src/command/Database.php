<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\command;

use think\admin\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

/**
 * 数据库修复优化指令
 * Class Database
 * @package think\admin\command
 */
class Database extends Command
{
    public function configure()
    {
        $this->setName('xadmin:database');
        $this->addArgument('action', Argument::OPTIONAL, 'repair|optimize', 'optimize');
        $this->setDescription('Database Optimize and Repair for ThinkAdmin');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return void
     */
    public function execute(Input $input, Output $output): void
    {
        $method = $input->getArgument('action');
        if (in_array($method, ['repair', 'optimize'])) {
            $this->{"_{$method}"}();
        } else {
            $this->output->error("Wrong operation, currently allow repair|optimize");
        }
    }

    /**
     * 修复数据表
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _repair(): void
    {
        $this->setQueueProgress("正在获取需要修复的数据表", 0);
        [$total, $used] = [count($tables = $this->getTables()), 0];
        $this->setQueueProgress("总共需要修复 {$total} 张数据表", 0);
        foreach ($tables as $table) {
            $this->queue->message($total, ++$used, "正在修复数据表 {$table}");
            $this->app->db->query("REPAIR TABLE `{$table}`");
            $this->queue->message($total, $used, "完成修复数据表 {$table}", 1);
        }
        $this->queue->success("已完成对 {$total} 张数据表修复操作");
    }

    /**
     * 优化所有数据表
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _optimize(): void
    {
        $this->setQueueProgress("正在获取需要优化的数据表", 0);
        [$total, $used] = [count($tables = $this->getTables()), 0];
        $this->setQueueProgress("总共需要优化 {$total} 张数据表", 0);
        foreach ($tables as $table) {
            $this->queue->message($total, ++$used, "正在优化数据表 {$table}");
            $this->app->db->query("OPTIMIZE TABLE `{$table}`");
            $this->queue->message($total, $used, "完成优化数据表 {$table}", 1);
        }
        $this->queue->success("已完成对 {$total} 张数据表优化操作");
    }

    /**
     * 获取数据库的数据表
     * @return array
     */
    protected function getTables(): array
    {
        $tables = [];
        foreach ($this->app->db->query("show tables") as $item) {
            $tables = array_merge($tables, array_values($item));
        }
        return $tables;
    }

}