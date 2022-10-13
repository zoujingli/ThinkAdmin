<?php

use think\migration\Migrator;

class DataUserPayment extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_user_payment";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'comment' => '订单单号'])
            ->addColumn('order_name', 'string', ['limit' => 255, 'default' => '', 'comment' => '订单描述'])
            ->addColumn('order_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单金额'])
            ->addColumn('payment_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '支付编号'])
            ->addColumn('payment_type', 'string', ['limit' => 50, 'default' => '', 'comment' => '支付通道'])
            ->addColumn('payment_trade', 'string', ['limit' => 100, 'default' => '', 'comment' => '支付单号'])
            ->addColumn('payment_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '支付状态'])
            ->addColumn('payment_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '支付金额'])
            ->addColumn('payment_datatime', 'string', ['limit' => 20, 'default' => '', 'comment' => '支付时间'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
