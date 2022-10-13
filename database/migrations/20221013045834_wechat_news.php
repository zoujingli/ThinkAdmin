<?php

use think\migration\Migrator;

/**
 * 微信图文数据
 */
class WechatNews extends Migrator
{
    private $name = 'wechat_news';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '微信-图文',
        ])
            ->addColumn('media_id', 'string', ['limit' => 100, 'default' => '', 'comment' => '永久素材编号'])
            ->addColumn('local_url', 'string', ['limit' => 500, 'default' => '', 'comment' => '本地文件链接'])
            ->addColumn('article_id', 'string', ['limit' => 100, 'default' => '', 'comment' => '关联文章编号(用英文逗号做分割)'])
            ->addColumn('is_deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除(1删除,0未删)'])
            ->addColumn('create_by', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '创建用户'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('media_id', ['name' => 'idx_wechat_news_media_id'])
            ->addIndex('article_id', ['name' => 'idx_wechat_news_article_id'])
            ->addIndex('is_deleted', ['name' => 'idx_wechat_news_deleted'])
            ->save();
    }
}
