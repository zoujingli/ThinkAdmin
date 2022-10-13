<?php

use think\migration\Migrator;

/**
 * 用户等级管理
 */
class BaseUserUpgrade extends Migrator
{
    public function change()
    {

        // 当前操作
        $table = "base_user_upgrade";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-等级',
        ])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '用户级别名称'])
            ->addColumn('number', 'integer', ['limit' => 2, 'default' => 0, 'comment' => '用户级别序号'])
            ->addColumn('rebate_rule', 'string', ['limit' => 255, 'default' => '', 'comment' => '用户奖利规则'])
            ->addColumn('upgrade_type', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '会员升级规则(0单个,1同时)'])
            ->addColumn('upgrade_team', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '团队人数统计(0不计,1累计)'])
            ->addColumn('goods_vip_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '入会礼包状态'])
            ->addColumn('order_amount_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '订单金额状态'])
            ->addColumn('order_amount_number', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单金额累计'])
            ->addColumn('teams_users_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '团队人数状态'])
            ->addColumn('teams_users_number', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '团队人数累计'])
            ->addColumn('teams_direct_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '直推人数状态'])
            ->addColumn('teams_direct_number', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '直推人数累计'])
            ->addColumn('teams_indirect_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '间推人数状态'])
            ->addColumn('teams_indirect_number', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '间推人数累计'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'comment' => '用户级别描述'])
            ->addColumn('utime', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '等级更新时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '用户等级状态(1使用,0禁用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '等级创建时间'])
            ->save();
    }
}
