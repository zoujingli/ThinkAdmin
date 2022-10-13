<?php

use think\migration\Migrator;

/**
 * 系统通用数据
 */
class SystemData extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = 'system_data';
        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-数据',
        ])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '配置名'])
            ->addColumn('value', 'text', ['default' => '', 'comment' => '配置值'])
            ->addIndex('type', ['name' => 'idx_system_data_name'])
            ->save();
    }
}
