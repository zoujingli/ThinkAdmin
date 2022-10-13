<?php

use think\migration\Migrator;

class ShopOrderItem extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "shop_order_item";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '商城用户编号'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'comment' => '商城订单单号'])
            ->addColumn('goods_sku', 'string', ['limit' => 20, 'default' => '', 'comment' => '商城商品SKU'])
            ->addColumn('goods_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '商城商品编号'])
            ->addColumn('goods_spec', 'string', ['limit' => 100, 'default' => '', 'comment' => '商城商品规格'])
            ->addColumn('goods_name', 'string', ['limit' => 250, 'default' => '', 'comment' => '商城商品名称'])
            ->addColumn('goods_cover', 'string', ['limit' => 500, 'default' => '', 'comment' => '商品封面图片'])
            ->addColumn('goods_payment', 'string', ['limit' => 999, 'default' => '', 'comment' => '指定支付通道'])
            ->addColumn('price_market', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '商品市场单价'])
            ->addColumn('price_selling', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '商品销售单价'])
            ->addColumn('total_market', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '商品市场总价'])
            ->addColumn('total_selling', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '商品销售总价'])
            ->addColumn('reward_balance', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '商品奖励余额'])
            ->addColumn('reward_integral', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '商品奖励积分'])
            ->addColumn('stock_sales', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '包含商品数量'])
            ->addColumn('vip_name', 'string', ['limit' => 30, 'default' => '', 'comment' => '用户等级名称'])
            ->addColumn('vip_code', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户等级序号'])
            ->addColumn('vip_entry', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '是否入会礼包(0非礼包,1是礼包)'])
            ->addColumn('vip_upgrade', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '升级用户等级'])
            ->addColumn('truck_type', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '物流配送类型(0虚物,1实物)'])
            ->addColumn('truck_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '快递邮费模板'])
            ->addColumn('truck_number', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '快递计费基数'])
            ->addColumn('rebate_type', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '参与返利状态(0不返,1返利)'])
            ->addColumn('rebate_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '参与返利金额'])
            ->addColumn('discount_id', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '优惠方案编号'])
            ->addColumn('discount_rate', 'decimal', ['precision' => 20, 'scale' => 6, 'default' => '100.000000', 'comment' => '销售价格折扣'])
            ->addColumn('discount_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '商品优惠金额'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '商品状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '订单创建时间'])
            ->save();
    }
}
