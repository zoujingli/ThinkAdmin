<?php

use think\migration\Migrator;

/**
 * 系统任务数据
 */
class SystemQueue extends Migrator
{
    private $name = 'system_queue';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-任务',
        ])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '任务编号'])
            ->addColumn('title', 'string', ['limit' => 80, 'default' => '', 'comment' => '任务名称'])
            ->addColumn('command', 'string', ['limit' => 500, 'default' => '', 'comment' => '执行指令'])
            ->addColumn('exec_pid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '执行进程'])
            ->addColumn('exec_data', 'text', ['limit' => 20, 'default' => 0, 'comment' => '执行参数'])
            ->addColumn('exec_time', 'decimal', ['precision' => 20, 'scale' => 4, 'default' => 0, 'comment' => '执行时间'])
            ->addColumn('outer_time', 'decimal', ['precision' => 20, 'scale' => 4, 'default' => 0, 'comment' => '结束时间'])
            ->addColumn('loops_time', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '循环时间'])
            ->addColumn('attempts', 'string', ['limit' => 500, 'default' => '', 'comment' => '执行次数'])
            ->addColumn('rscript', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '任务类型(0单例,1多例)'])
            ->addColumn('status', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '任务状态(1新任务,2处理中,3成功,4失败)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_system_queue_code'])
            ->addIndex('title', ['name' => 'idx_system_queue_title'])
            ->addIndex('status', ['name' => 'idx_system_queue_status'])
            ->addIndex('exec_time', ['name' => 'idx_system_queue_exec_time'])
            ->addIndex('create_at', ['name' => 'idx_system_queue_create_at'])
            ->save();
    }
}
