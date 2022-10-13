<?php

use think\migration\Migrator;

/**
 * 系统-授权
 */
class SystemAuthNode extends Migrator
{
    private $name = 'system_auth_node';

    public function change()
    {
        // 存在则跳过
        if ($this->hasTable($this->name)) {
            return;
        }
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-授权',
        ])
            ->addColumn('auth', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '角色编号'])
            ->addColumn('node', 'string', ['limit' => 200, 'default' => '', 'comment' => '节点路径'])
            ->addIndex('auth', ['name' => 'idx_system_auth_node_auth'])
            ->addIndex('node', ['name' => 'idx_system_auth_node_node'])
            ->save();
    }
}
