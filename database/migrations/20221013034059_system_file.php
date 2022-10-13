<?php

use think\migration\Migrator;

/**
 * 系统文件数据
 */
class SystemFile extends Migrator
{
    private $name = 'system_file';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-文件',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '上传类型'])
            ->addColumn('hash', 'string', ['limit' => 32, 'default' => '', 'comment' => '文件哈希'])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '文件名称'])
            ->addColumn('xext', 'string', ['limit' => 100, 'default' => '', 'comment' => '文件后缀'])
            ->addColumn('xurl', 'string', ['limit' => 500, 'default' => '', 'comment' => '访问链接'])
            ->addColumn('xkey', 'string', ['limit' => 500, 'default' => '', 'comment' => '文件路径'])
            ->addColumn('mime', 'string', ['limit' => 100, 'default' => '', 'comment' => '文件类型'])
            ->addColumn('size', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '文件大小'])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户编号'])
            ->addColumn('isfast', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '是否秒传'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_at', 'datetime', ['limit' => 20, 'default' => '', 'comment' => '创建时间'])
            ->addColumn('update_at', 'datetime', ['limit' => 20, 'default' => 0, 'comment' => '更新时间'])
            ->addIndex('type', ['name' => 'idx_system_file_type'])
            ->addIndex('hash', ['name' => 'idx_system_file_hash'])
            ->addIndex('uuid', ['name' => 'idx_system_file_uuid'])
            ->addIndex('xext', ['name' => 'idx_system_file_xext'])
            ->addIndex('status', ['name' => 'idx_system_file_status'])
            ->addIndex('issafe', ['name' => 'idx_system_file_issafe'])
            ->addIndex('isfast', ['name' => 'idx_system_file_isfast'])
            ->save();
    }

}
