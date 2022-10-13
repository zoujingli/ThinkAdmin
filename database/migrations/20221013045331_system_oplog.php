<?php

use think\migration\Migrator;

/**
 * 系统日志数据
 */
class SystemOplog extends Migrator
{
    private $name = 'system_oplog';

    public function change()
    {
        // 存在则跳过
        if ($this->hasTable($this->name)) {
            return;
        }
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-日志',
        ])
            ->addColumn('node', 'string', ['limit' => 200, 'default' => '', 'comment' => '当前操作节点'])
            ->addColumn('geoip', 'string', ['limit' => 20, 'default' => '', 'comment' => '操作者IP地址'])
            ->addColumn('action', 'string', ['limit' => 200, 'default' => '', 'comment' => '操作行为名称'])
            ->addColumn('content', 'string', ['limit' => 1024, 'default' => '', 'comment' => '操作内容描述'])
            ->addColumn('username', 'string', ['limit' => 50, 'default' => '', 'comment' => '操作人用户名'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
