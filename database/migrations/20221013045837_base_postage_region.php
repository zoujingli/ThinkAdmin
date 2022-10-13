<?php

use think\migration\Migrator;

/**
 * 快递区域数据
 */
class BasePostageRegion extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "base_postage_region";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '',
        ])
            ->addColumn('pid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '上级PID'])
            ->addColumn('first', 'string', ['limit' => 50, 'default' => '', 'comment' => '首字母'])
            ->addColumn('short', 'string', ['limit' => 100, 'default' => '', 'comment' => '区域简称'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '区域名称'])
            ->addColumn('level', 'integer', ['limit' => 4, 'default' => 0, 'comment' => '区域层级'])
            ->addColumn('pinyin', 'string', ['limit' => 100, 'default' => '', 'comment' => '区域拼音'])
            ->addColumn('code', 'string', ['limit' => 100, 'default' => '', 'comment' => '区域邮编'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '使用状态'])
            ->addColumn('lng', 'string', ['limit' => 100, 'default' => '', 'comment' => '所在经度'])
            ->addColumn('lat', 'string', ['limit' => 100, 'default' => '', 'comment' => '所在纬度'])
            ->save();
    }
}
