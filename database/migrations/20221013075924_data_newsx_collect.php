<?php

use think\migration\Migrator;

class DataNewsxCollect extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_news_x_collect";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '记录类型(1收藏,2点赞,3历史,4评论)'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '文章编号'])
            ->addColumn('reply', 'text', ['default' => null, 'comment' => '评论内容'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '记录状态(0无效,1待审核,2已审核)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
