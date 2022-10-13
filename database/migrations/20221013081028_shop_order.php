<?php

use think\migration\Migrator;

class ShopOrder extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "shop_order";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '下单用户编号'])
            ->addColumn('puid1', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '推荐一层用户'])
            ->addColumn('puid2', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '推荐二层用户'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'comment' => '商品订单单号'])
            ->addColumn('amount_real', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单实际金额'])
            ->addColumn('amount_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单统计金额'])
            ->addColumn('amount_goods', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '商品统计金额'])
            ->addColumn('amount_reduct', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '随机减免金额'])
            ->addColumn('amount_express', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '快递费用金额'])
            ->addColumn('amount_discount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '折扣后的金额'])
            ->addColumn('payment_type', 'string', ['limit' => 20, 'default' => '', 'comment' => '实际支付平台'])
            ->addColumn('payment_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '实际通道编号'])
            ->addColumn('payment_allow', 'string', ['limit' => 999, 'default' => '', 'comment' => '允许支付通道'])
            ->addColumn('payment_trade', 'string', ['limit' => 80, 'default' => '', 'comment' => '实际支付单号'])
            ->addColumn('payment_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '实际支付状态'])
            ->addColumn('payment_image', 'string', ['limit' => 999, 'default' => '', 'comment' => '支付凭证图片'])
            ->addColumn('payment_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '实际支付金额'])
            ->addColumn('payment_balance', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '余额抵扣金额'])
            ->addColumn('payment_remark', 'string', ['limit' => 500, 'default' => '', 'comment' => '支付结果描述'])
            ->addColumn('payment_datetime', 'string', ['limit' => 20, 'default' => '', 'comment' => '支付到账时间'])
            ->addColumn('number_goods', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '订单商品数量'])
            ->addColumn('number_express', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '订单快递计数'])
            ->addColumn('truck_type', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '物流配送类型(0无需配送,1需要配送)'])
            ->addColumn('rebate_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '参与返利金额'])
            ->addColumn('reward_balance', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '奖励账户余额'])
            ->addColumn('order_remark', 'string', ['limit' => 999, 'default' => '', 'comment' => '订单用户备注'])
            ->addColumn('cancel_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '订单取消状态'])
            ->addColumn('cancel_remark', 'string', ['limit' => 200, 'default' => '', 'comment' => '订单取消描述'])
            ->addColumn('cancel_datetime', 'string', ['limit' => 20, 'default' => '', 'comment' => '订单取消时间'])
            ->addColumn('deleted_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '订单删除状态(0未删,1已删)'])
            ->addColumn('deleted_remark', 'string', ['limit' => 255, 'default' => '', 'comment' => '订单删除描述'])
            ->addColumn('deleted_datetime', 'string', ['limit' => 20, 'default' => '', 'comment' => '订单删除时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '订单流程状态(0已取消,1预订单,2待支付,3支付中,4已支付,5已发货,6已完成)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '订单创建时间'])
            ->save();

    }
}
