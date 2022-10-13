<?php

use think\migration\Migrator;

/**
 * 前端用户余额数据
 */
class DataUserBalance extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_user_balance";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-余额',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '充值编号'])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '充值名称'])
            ->addColumn('remark', 'string', ['limit' => 999, 'default' => '', 'comment' => '充值备注'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '充值金额'])
            ->addColumn('upgrade', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '强制升级'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态'])
            ->addColumn('create_by', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '系统用户'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
