<?php

use think\migration\Migrator;

class DataNewsMark extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_news_mark";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '标签名称'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'comment' => '标签说明'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '标签状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
