<?php

use think\migration\Migrator;

/**
 * 商品主体数据
 */
class ShopGoods extends Migrator
{
    public function change()
    {

        // 当前操作
        $table = "shop_goods";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '商品编号'])
            ->addColumn('name', 'string', ['limit' => 500, 'default' => '', 'comment' => '商品名称'])
            ->addColumn('marks', 'string', ['limit' => 999, 'default' => '', 'comment' => '商品标签'])
            ->addColumn('cateids', 'string', ['limit' => 999, 'default' => '', 'comment' => '分类编号'])
            ->addColumn('cover', 'string', ['limit' => 999, 'default' => '', 'comment' => '商品封面'])
            ->addColumn('slider', 'text', ['default' => null, 'comment' => '轮播图片'])
            ->addColumn('remark', 'string', ['limit' => 999, 'default' => '', 'comment' => '商品描述'])
            ->addColumn('content', 'text', ['default' => null, 'comment' => '商品详情'])
            ->addColumn('payment', 'string', ['limit' => 999, 'default' => '', 'comment' => '支付方式'])
            ->addColumn('data_specs', 'text', ['default' => null, 'comment' => '商品规格(JSON)'])
            ->addColumn('data_items', 'text', ['default' => null, 'comment' => '商品规格(JSON)'])
            ->addColumn('stock_total', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '商品库存统计'])
            ->addColumn('stock_sales', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '商品销售统计'])
            ->addColumn('stock_virtual', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '商品虚拟销量'])
            ->addColumn('price_selling', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '最低销售价格'])
            ->addColumn('price_market', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '最低市场价格'])
            ->addColumn('discount_id', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '折扣方案编号'])
            ->addColumn('truck_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '物流运费模板'])
            ->addColumn('truck_type', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '物流配送(0无需配送,1需要配送)'])
            ->addColumn('rebate_type', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '参与返利(0无需返利,1需要返利)'])
            ->addColumn('vip_entry', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '入会礼包(0非入会礼包,1是入会礼包)'])
            ->addColumn('vip_upgrade', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '购买升级等级(0不升级,其他升级)'])
            ->addColumn('limit_low_vip', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '限制最低等级(0不限制,其他限制)'])
            ->addColumn('limit_max_num', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '最大购买数量(0不限制,其他限制)'])
            ->addColumn('num_read', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '访问阅读统计'])
            ->addColumn('state_hot', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '设置热度标签'])
            ->addColumn('state_home', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '设置首页推荐'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '列表排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '商品状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
