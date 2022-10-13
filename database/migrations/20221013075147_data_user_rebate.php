<?php

use think\migration\Migrator;

class DataUserRebate extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_user_rebate";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('date', 'string', ['limit' => 20, 'default' => '', 'comment' => '奖励日期'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '奖励编号'])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '奖励类型'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '奖励名称'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '奖励数量'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'comment' => '订单单号'])
            ->addColumn('order_uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '订单用户'])
            ->addColumn('order_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单金额'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '生效状态(0未生效,1已生效)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态(0未删除,1已删除)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
