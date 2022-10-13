<?php

use think\migration\Migrator;

class DataUserAddress extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "data_user_address";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '地址类型(0普通,1默认)'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '地址编号'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '收货姓名'])
            ->addColumn('phone', 'string', ['limit' => 20, 'default' => '', 'comment' => '收货手机'])
            ->addColumn('idcode', 'string', ['limit' => 255, 'default' => '', 'comment' => '身体证号'])
            ->addColumn('idimg1', 'string', ['limit' => 500, 'default' => '', 'comment' => '身份证正面'])
            ->addColumn('idimg2', 'string', ['limit' => 500, 'default' => '', 'comment' => '身份证反面'])
            ->addColumn('province', 'string', ['limit' => 100, 'default' => '', 'comment' => '地址-省份'])
            ->addColumn('city', 'string', ['limit' => 100, 'default' => '', 'comment' => '地址-城市'])
            ->addColumn('area', 'string', ['limit' => 100, 'default' => '', 'comment' => '地址-区域'])
            ->addColumn('address', 'string', ['limit' => 255, 'default' => '', 'comment' => '地址-详情'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
