<?php

use think\migration\Migrator;

/**
 * 系统字典数据
 */
class SystemBase extends Migrator
{
    private $name = 'system_base';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-字典',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '数据类型'])
            ->addColumn('code', 'string', ['limit' => 100, 'default' => '', 'comment' => '数据代码'])
            ->addColumn('name', 'string', ['limit' => 500, 'default' => '', 'comment' => '数据名称'])
            ->addColumn('content', 'text', ['limit' => 500, 'default' => '', 'comment' => '数据内容'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除(0正常,1已删)'])
            ->addColumn('deleted_at', 'string', ['limit' => 20, 'default' => '', 'comment' => '删除时间'])
            ->addColumn('deleted_by', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '删除用户'])
            ->addIndex('type', ['name' => 'idx_system_base_type'])
            ->addIndex('code', ['name' => 'idx_system_base_code'])
            ->addIndex('name', ['name' => 'idx_system_base_name'])
            ->addIndex('sort', ['name' => 'idx_system_base_sort'])
            ->addIndex('status', ['name' => 'idx_system_base_status'])
            ->addIndex('deleted', ['name' => 'idx_system_base_deleted'])
            ->save();
    }
}
