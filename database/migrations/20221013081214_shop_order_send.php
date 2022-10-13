<?php

use think\migration\Migrator;

/**
 * 订单发货数据
 */
class ShopOrderSend extends Migrator
{
    public function change()
    {

        // 当前操作
        $table = "shop_order_send";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-订单-发货',
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
            ->save();
    }
}
