<?php

use think\migration\Migrator;

/**
 * 商城数据
 */
class InstallShop extends Migrator
{
    public function change()
    {
        $this->_goods();
        $this->_goodsCate();
        $this->_goodsMark();
        $this->_goodsItems();
        $this->_goodsStock();
        $this->_order();
        $this->_orderItem();
        $this->_orderSend();
    }

    private function _goods()
    {
        // 当前数据表
        $table = 'shop_goods';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-内容',
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
            ->addIndex('code', ['name' => 'idx_shop_goods_code'])
            ->addIndex('status', ['name' => 'idx_shop_goods_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_goods_deleted'])
            ->save();
    }

    private function _goodsCate()
    {
        // 当前数据表
        $table = 'shop_goods_cate';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-分类',
        ])
            ->addColumn('pid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '上级分类'])
            ->addColumn('name', 'string', ['limit' => 255, 'default' => '', 'comment' => '分类名称'])
            ->addColumn('cover', 'string', ['limit' => 500, 'default' => '', 'comment' => '分类图标'])
            ->addColumn('remark', 'string', ['limit' => 999, 'default' => '', 'comment' => '分类描述'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '使用状态'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('sort', ['name' => 'idx_shop_goods_cate_sort'])
            ->addIndex('status', ['name' => 'idx_shop_goods_cate_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_goods_cate_deleted'])
            ->save();
    }

    private function _goodsItems()
    {
        // 当前数据表
        $table = 'shop_goods_item';

        // 存在则跳过
        if ($this->hasTable($table)) return;

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
            ->addIndex('goods_code', ['name' => 'idx_shop_goods_item_goods_code'])
            ->addIndex('goods_spec', ['name' => 'idx_shop_goods_item_goods_spec'])
            ->addIndex('status', ['name' => 'idx_shop_goods_item_status'])
            ->save();
    }

    private function _goodsMark()
    {
        // 当前数据表
        $table = 'shop_goods_mark';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-标签',
        ])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '标签名称'])
            ->addColumn('remark', 'string', ['limit' => 200, 'default' => '', 'comment' => '标签描述'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '标签状态(1使用,0禁用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('sort', ['name' => 'idx_shop_goods_mark_sort'])
            ->addIndex('status', ['name' => 'idx_shop_goods_mark_status'])
            ->save();
    }

    private function _goodsStock()
    {
        // 当前数据表
        $table = 'shop_goods_stock';

        // 存在则跳过
        if ($this->hasTable($table)) return;

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
            ->addIndex('status', ['name' => 'idx_shop_goods_stock_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_goods_stock_deleted'])
            ->save();
    }

    private function _order()
    {
        // 当前数据表
        $table = 'shop_order';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-订单-内容',
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
            ->addIndex('uuid', ['name' => 'idx_shop_order_uuid'])
            ->addIndex('puid1', ['name' => 'idx_shop_order_puid1'])
            ->addIndex('status', ['name' => 'idx_shop_order_status'])
            ->addIndex('order_no', ['name' => 'idx_shop_order_order_no'])
            ->addIndex('cancel_status', ['name' => 'idx_shop_order_cancel_status'])
            ->addIndex('payment_status', ['name' => 'idx_shop_order_payment_status'])
            ->addIndex('deleted_status', ['name' => 'idx_shop_order_deleted_status'])
            ->save();

    }

    private function _orderItem()
    {
        // 当前数据表
        $table = 'shop_order_item';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-订单-商品',
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
            ->addIndex('status', ['name' => 'idx_shop_order_item_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_order_item_deleted'])
            ->addIndex('order_no', ['name' => 'idx_shop_order_item_order_no'])
            ->addIndex('goods_sku', ['name' => 'idx_shop_order_item_goods_sku'])
            ->addIndex('goods_code', ['name' => 'idx_shop_order_item_goods_code'])
            ->addIndex('goods_spec', ['name' => 'idx_shop_order_item_goods_spec'])
            ->addIndex('rebate_type', ['name' => 'idx_shop_order_item_rebate_type'])
            ->save();
    }

    private function _orderSend()
    {
        // 当前数据表
        $table = 'shop_order_send';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-订单-配送',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '商城用户编号'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'comment' => '商城订单单号'])
            ->addColumn('address_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '配送地址编号'])
            ->addColumn('address_name', 'string', ['limit' => 50, 'default' => '', 'comment' => '配送收货人姓名'])
            ->addColumn('address_phone', 'string', ['limit' => 20, 'default' => '', 'comment' => '配送收货人手机'])
            ->addColumn('address_idcode', 'string', ['limit' => 100, 'default' => '', 'comment' => '配送收货人证件号码'])
            ->addColumn('address_idimg1', 'string', ['limit' => 500, 'default' => '', 'comment' => '配送收货人证件正面'])
            ->addColumn('address_idimg2', 'string', ['limit' => 500, 'default' => '', 'comment' => '配送收货人证件反面'])
            ->addColumn('address_province', 'string', ['limit' => 30, 'default' => '', 'comment' => '配送地址的省份'])
            ->addColumn('address_city', 'string', ['limit' => 30, 'default' => '', 'comment' => '配送地址的城市'])
            ->addColumn('address_area', 'string', ['limit' => 30, 'default' => '', 'comment' => '配送地址的区域'])
            ->addColumn('address_content', 'string', ['limit' => 255, 'default' => '', 'comment' => '配送的详细地址'])
            ->addColumn('address_datetime', 'string', ['limit' => 20, 'default' => '', 'comment' => '地址确认时间'])
            ->addColumn('template_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '配送模板编号'])
            ->addColumn('template_count', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '快递计费基数'])
            ->addColumn('template_remark', 'string', ['limit' => 255, 'default' => '', 'comment' => '配送计算描述'])
            ->addColumn('template_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '配送计算金额'])
            ->addColumn('company_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '快递公司编码'])
            ->addColumn('company_name', 'string', ['limit' => 100, 'default' => '', 'comment' => '快递公司名称'])
            ->addColumn('send_number', 'string', ['limit' => 100, 'default' => '', 'comment' => '快递运送单号'])
            ->addColumn('send_remark', 'string', ['limit' => 255, 'default' => '', 'comment' => '快递发送备注'])
            ->addColumn('send_datetime', 'string', ['limit' => 20, 'default' => '', 'comment' => '快递发送时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '发货商品状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '发货删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('uuid', ['name' => 'idx_shop_order_send_uuid'])
            ->addIndex('status', ['name' => 'idx_shop_order_send_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_order_send_deleted'])
            ->addIndex('order_no', ['name' => 'idx_shop_order_send_order_no'])
            ->save();
    }
}
