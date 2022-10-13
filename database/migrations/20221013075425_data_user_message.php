<?php

use think\migration\Migrator;

/**
 * 前端用户短信数据
 */
class DataUserMessage extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_user_message";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-短信',
        ])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '短信类型'])
            ->addColumn('msgid', 'string', ['limit' => 50, 'default' => '', 'comment' => '消息编号'])
            ->addColumn('phone', 'string', ['limit' => 100, 'default' => '', 'comment' => '目标手机'])
            ->addColumn('region', 'string', ['limit' => 100, 'default' => '', 'comment' => '国家编号'])
            ->addColumn('result', 'string', ['limit' => 100, 'default' => '', 'comment' => '返回结果'])
            ->addColumn('content', 'string', ['limit' => 512, 'default' => '', 'comment' => '短信内容'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '短信状态(0失败,1成功)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
