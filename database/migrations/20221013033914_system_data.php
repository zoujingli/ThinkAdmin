<?php

use think\migration\Migrator;

/**
 * 系统通用数据
 */
class SystemData extends Migrator
{
    private $name = 'system_data';

    public function change()
    {
        // 存在则跳过
        if ($this->hasTable($this->name)) {
            return;
        }
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-数据',
        ])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '配置名'])
            ->addColumn('value', 'text', ['limit' => 2048, 'default' => '', 'comment' => '配置值'])
            ->addIndex('type', ['name' => 'idx_system_data_name'])
            ->save();
    }
}
