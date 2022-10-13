<?php

use think\migration\Migrator;

/**
 * 系统-授权
 */
class SystemAuthNode extends Migrator
{
    protected $name = 'system_auth_node';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-授权',
        ])
            ->addColumn('auth', 'biginteger', ['limit' => 20, 'default' => 0, 'comment' => '角色'])
            ->addColumn('node', 'string', ['limit' => 200, 'default' => '', 'comment' => '节点'])
            ->addIndex('auth', ['name' => 'idx_system_auth_node_title'])
            ->addIndex('auth', ['name' => 'idx_system_auth_node_status'])
            ->save();
    }
}
