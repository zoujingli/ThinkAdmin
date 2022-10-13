<?php

use think\migration\Migrator;

class DataUserToken extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_user_token";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '授权类型'])
            ->addColumn('time', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '有效时间'])
            ->addColumn('token', 'string', ['limit' => 32, 'default' => '', 'comment' => '授权令牌'])
            ->addColumn('tokenv', 'string', ['limit' => 32, 'default' => '', 'comment' => '授权验证'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
