<?php

use think\migration\Migrator;

/**
 * 商品规格数据
 */
class ShopGoodsItem extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "shop_goods_item";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-规格',
        ])
            ->addColumn('goods_sku', 'string', ['limit' => 20, 'default' => '', 'comment' => '商品SKU'])
            ->addColumn('goods_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '商品编号'])
            ->addColumn('goods_spec', 'string', ['limit' => 100, 'default' => '', 'comment' => '商品规格'])
            ->addColumn('stock_sales', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '销售数量'])
            ->addColumn('stock_total', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '商品库存'])
            ->addColumn('price_selling', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '销售价格'])
            ->addColumn('price_market', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '市场价格'])
            ->addColumn('number_virtual', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '虚拟销量'])
            ->addColumn('number_express', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '配送计件'])
            ->addColumn('reward_balance', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '奖励余额'])
            ->addColumn('reward_integral', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '奖励积分'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '商品状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();

    }
}
