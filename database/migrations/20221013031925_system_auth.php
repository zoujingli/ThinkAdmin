<?php

use think\migration\Migrator;

/**
 * 系统权限数据
 */
class SystemAuth extends Migrator
{
    protected $name = 'system_auth';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-权限',
        ])
            ->addColumn('title', 'string', ['limit' => 80, 'default' => '', 'comment' => '权限名称'])
            ->addColumn('utype', 'string', ['limit' => 50, 'default' => '', 'comment' => '身份权限'])
            ->addColumn('desc', 'string', ['limit' => 500, 'default' => '', 'comment' => '备注说明'])
            ->addColumn('sort', 'biginteger', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'biginteger', ['limit' => 20, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('sort', ['name' => 'idx_system_auth_sort'])
            ->addIndex('title', ['name' => 'idx_system_auth_title'])
            ->addIndex('status', ['name' => 'idx_system_auth_status'])
            ->save();
    }
}
