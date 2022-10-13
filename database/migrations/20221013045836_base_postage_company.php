<?php

use think\migration\Migrator;

/**
 * 快递公司数据
 */
class BasePostageCompany extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = "base_postage_company";

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-快递-公司',
        ])
            ->addColumn('name', 'string', ['limit' => 50, 'default' => '', 'comment' => '快递公司名称'])
            ->addColumn('code_1', 'string', ['limit' => 50, 'default' => '', 'comment' => '快递公司代码'])
            ->addColumn('code_2', 'string', ['limit' => 50, 'default' => '', 'comment' => '百度快递100代码'])
            ->addColumn('code_3', 'string', ['limit' => 50, 'default' => '', 'comment' => '官方快递100代码'])
            ->addColumn('remark', 'string', ['limit' => 512, 'default' => '', 'comment' => '快递公司描述'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '激活状态(0无效,1有效)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('name', ['name' => 'idx_base_postage_company_name'])
            ->addIndex('sort', ['name' => 'idx_base_postage_company_sort'])
            ->addIndex('code_1', ['name' => 'idx_base_postage_company_code_1'])
            ->addIndex('code_2', ['name' => 'idx_base_postage_company_code_2'])
            ->addIndex('code_3', ['name' => 'idx_base_postage_company_code_3'])
            ->addIndex('status', ['name' => 'idx_base_postage_company_status'])
            ->addIndex('deleted', ['name' => 'idx_base_postage_company_deleted'])
            ->save();
    }
}
