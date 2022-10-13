<?php

use think\migration\Migrator;

/**
 * 系统权限数据
 */
class SystemAuth extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = 'system_auth';

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }
        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-权限',
        ])
            ->addColumn('title', 'string', ['limit' => 80, 'default' => '', 'comment' => '权限名称'])
            ->addColumn('utype', 'string', ['limit' => 50, 'default' => '', 'comment' => '身份权限'])
            ->addColumn('desc', 'string', ['limit' => 500, 'default' => '', 'comment' => '备注说明'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('sort', ['name' => 'idx_system_auth_sort'])
            ->addIndex('title', ['name' => 'idx_system_auth_title'])
            ->addIndex('status', ['name' => 'idx_system_auth_status'])
            ->save();
    }
}
