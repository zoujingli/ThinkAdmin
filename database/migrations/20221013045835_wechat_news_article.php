<?php

use think\migration\Migrator;

/**
 * 微信文章数据
 */
class WechatNewsArticle extends Migrator
{
    private $name = 'wechat_news_article';

    public function change()
    {
        // 存在则跳过
        if ($this->hasTable($this->name)) {
            return;
        }
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '微信-文章',
        ])
            ->addColumn('title', 'string', ['limit' => 100, 'default' => '', 'comment' => '素材标题'])
            ->addColumn('local_url', 'string', ['limit' => 500, 'default' => '', 'comment' => '素材链接'])
            ->addColumn('show_cover_pic', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '显示封面(0隐藏,1显示)'])
            ->addColumn('author', 'string', ['limit' => 20, 'default' => '', 'comment' => '文章作者'])
            ->addColumn('digest', 'string', ['limit' => 300, 'default' => '', 'comment' => '摘要内容'])
            ->addColumn('content', 'text', ['default' => '', 'comment' => '图文内容'])
            ->addColumn('content_source_url', 'string', ['limit' => 200, 'default' => '', 'comment' => '原文地址'])
            ->addColumn('read_num', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '阅读数量'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
