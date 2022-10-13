<?php

use think\migration\Migrator;

class ShopGoodsCate extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "shop_goods_cate";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('pid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '上级分类'])
            ->addColumn('name', 'string', ['limit' => 255, 'default' => '', 'comment' => '分类名称'])
            ->addColumn('cover', 'string', ['limit' => 500, 'default' => '', 'comment' => '分类图标'])
            ->addColumn('remark', 'string', ['limit' => 999, 'default' => '', 'comment' => '分类描述'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '使用状态'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
