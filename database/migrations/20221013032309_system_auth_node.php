<?php

use think\migration\Migrator;

/**
 * 系统-授权
 */
class SystemAuthNode extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = 'system_auth_node';
        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-授权',
        ])
            ->addColumn('auth', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '角色编号'])
            ->addColumn('node', 'string', ['limit' => 200, 'default' => '', 'comment' => '节点路径'])
            ->addIndex('auth', ['name' => 'idx_system_auth_node_auth'])
            ->addIndex('node', ['name' => 'idx_system_auth_node_node'])
            ->save();
    }
}
