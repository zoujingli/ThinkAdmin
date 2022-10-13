<?php

use think\migration\Migrator;

class DataUser extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_user";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('pid0', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '临时推荐人UID'])
            ->addColumn('pid1', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '推荐人一级UID'])
            ->addColumn('pid2', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '推荐人二级UID'])
            ->addColumn('pids', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '推荐人绑定状态'])
            ->addColumn('path', 'string', ['limit' => 999, 'default' => '-', 'comment' => '推荐关系路径'])
            ->addColumn('layer', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '推荐关系层级'])
            ->addColumn('openid1', 'string', ['limit' => 50, 'default' => '', 'comment' => '小程序OPENID'])
            ->addColumn('openid2', 'string', ['limit' => 50, 'default' => '', 'comment' => '服务号OPENID'])
            ->addColumn('unionid', 'string', ['limit' => 50, 'default' => '', 'comment' => '公众号UnionID'])
            ->addColumn('phone', 'string', ['limit' => 20, 'default' => '', 'comment' => '用户手机'])
            ->addColumn('headimg', 'string', ['limit' => 500, 'default' => '', 'comment' => '用户头像'])
            ->addColumn('username', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户姓名'])
            ->addColumn('nickname', 'string', ['limit' => 99, 'default' => '', 'comment' => '用户昵称'])
            ->addColumn('password', 'string', ['limit' => 32, 'default' => '', 'comment' => '登录密码'])
            ->addColumn('region_province', 'string', ['limit' => 30, 'default' => '', 'comment' => '所在省份'])
            ->addColumn('region_city', 'string', ['limit' => 30, 'default' => '', 'comment' => '所在城市'])
            ->addColumn('region_area', 'string', ['limit' => 30, 'default' => '', 'comment' => '所在区域'])
            ->addColumn('base_age', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户年龄'])
            ->addColumn('base_sex', 'string', ['limit' => 10, 'default' => '', 'comment' => '用户性别'])
            ->addColumn('base_height', 'string', ['limit' => 10, 'default' => '', 'comment' => '用户身高'])
            ->addColumn('base_weight', 'string', ['limit' => 10, 'default' => '', 'comment' => '用户体重'])
            ->addColumn('base_birthday', 'string', ['limit' => 20, 'default' => '', 'comment' => '用户生日'])
            ->addColumn('vip_code', 'integer', ['limit' => 20, 'default' => 0, 'comment' => 'VIP等级编号'])
            ->addColumn('vip_name', 'string', ['limit' => 30, 'default' => '普通用户', 'comment' => 'VIP等级名称'])
            ->addColumn('vip_order', 'string', ['limit' => 20, 'default' => '', 'comment' => 'VIP升级订单'])
            ->addColumn('vip_datetime', 'string', ['limit' => 20, 'default' => '', 'comment' => 'VIP等级时间'])
            ->addColumn('buy_vip_entry', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '是否入会礼包'])
            ->addColumn('buy_last_date', 'string', ['limit' => 20, 'default' => '', 'comment' => '最后支付时间'])
            ->addColumn('rebate_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '返利金额统计'])
            ->addColumn('rebate_used', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '返利提现统计'])
            ->addColumn('rebate_lock', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '返利锁定统计'])
            ->addColumn('balance_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '累计充值统计'])
            ->addColumn('balance_used', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '已经使用统计'])
            ->addColumn('teams_users_total', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '团队人数统计'])
            ->addColumn('teams_users_direct', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '直属人数团队'])
            ->addColumn('teams_users_indirect', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '间接人数团队'])
            ->addColumn('order_amount_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单交易统计'])
            ->addColumn('teams_amount_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '二级团队业绩'])
            ->addColumn('teams_amount_direct', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '直属团队业绩'])
            ->addColumn('teams_amount_indirect', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '间接团队业绩'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'comment' => '用户备注描述'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '用户状态(1正常,0已黑)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '注册时间'])
            ->save();
    }
}
