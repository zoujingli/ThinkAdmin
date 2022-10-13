<?php

use think\migration\Migrator;

/**
 * 系统菜单数据
 */
class SystemMenu extends Migrator
{
    protected $name = 'system_menu';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-菜单',
        ])
            ->addColumn('pid', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '上级编号'])
            ->addColumn('title', 'string', ['limit' => 100, 'default' => '', 'comment' => '菜单名称'])
            ->addColumn('icon', 'string', ['limit' => 100, 'default' => '', 'comment' => '菜单图标'])
            ->addColumn('node', 'string', ['limit' => 100, 'default' => '', 'comment' => '节点代码'])
            ->addColumn('url', 'string', ['limit' => 500, 'default' => '', 'comment' => '链接节点'])
            ->addColumn('params', 'string', ['limit' => 500, 'default' => '', 'comment' => '链接参数'])
            ->addColumn('target', 'string', ['limit' => 20, 'default' => '_self', 'comment' => '打开方式'])
            ->addColumn('sort', 'biginteger', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('pid', ['name' => 'idx_system_menu_pid'])
            ->addIndex('sort', ['name' => 'idx_system_menu_sort'])
            ->addIndex('status', ['name' => 'idx_system_menu_status'])
            ->save();
    }
}
