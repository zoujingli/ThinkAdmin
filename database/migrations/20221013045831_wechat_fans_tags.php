<?php

use think\migration\Migrator;

/**
 * 微信标签数据
 */
class WechatFansTags extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = 'wechat_fans_tags';

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '微信-标签',
        ])
            ->addColumn('appid', 'string', ['limit' => 50, 'default' => '', 'comment' => '公众号编号'])
            ->addColumn('name', 'string', ['limit' => 50, 'default' => '', 'comment' => '标签名称'])
            ->addColumn('openid', 'string', ['limit' => 100, 'default' => '', 'comment' => 'OPENID'])
            ->addColumn('count', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '粉丝数量'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('appid', ['name' => 'idx_wechat_fans_appid'])
            ->save();
    }
}
