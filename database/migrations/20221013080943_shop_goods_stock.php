<?php

use think\migration\Migrator;

/**
 * 商品库存
 */
class ShopGoodsStock extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "shop_goods_stock";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-库存',
        ])
            ->addColumn('batch_no', 'string', ['limit' => 20, 'default' => '', 'comment' => '操作批量'])
            ->addColumn('goods_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '商品编号'])
            ->addColumn('goods_spec', 'string', ['limit' => 100, 'default' => '', 'comment' => '商品规格'])
            ->addColumn('goods_stock', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '入库数量'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '数据状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();

    }
}
