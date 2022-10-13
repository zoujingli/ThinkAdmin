<?php

use think\migration\Migrator;

/**
 * 系统配置数据
 */
class SystemConfig extends Migrator
{
    protected $name = 'system_config';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-配置',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '配置分类'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '配置名称'])
            ->addColumn('value', 'string', ['limit' => 2048, 'default' => '', 'comment' => '配置内容'])
            ->addIndex('type', ['name' => 'idx_system_config_type'])
            ->addIndex('name', ['name' => 'idx_system_config_name'])
            ->save();
    }
}
