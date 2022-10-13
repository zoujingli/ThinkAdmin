<?php

use think\migration\Migrator;

/**
 * 微信关键字数据
 */
class WechatKeys extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = 'wechat_keys';

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '微信-规则',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '类型(text,image,news)'])
            ->addColumn('keys', 'string', ['limit' => 100, 'default' => '', 'comment' => '关键字'])
            ->addColumn('appid', 'string', ['limit' => 50, 'default' => '', 'comment' => '公众号编号'])
            ->addColumn('content', 'text', ['default' => '', 'comment' => '文本内容'])
            ->addColumn('image_url', 'string', ['limit' => 500, 'default' => '', 'comment' => '图片链接'])
            ->addColumn('voice_url', 'string', ['limit' => 500, 'default' => '', 'comment' => '语音链接'])
            ->addColumn('music_title', 'string', ['limit' => 500, 'default' => '', 'comment' => '音乐标题'])
            ->addColumn('music_url', 'string', ['limit' => 500, 'default' => '', 'comment' => '音乐链接'])
            ->addColumn('music_image', 'string', ['limit' => 500, 'default' => '', 'comment' => '缩略图片'])
            ->addColumn('music_desc', 'string', ['limit' => 500, 'default' => '', 'comment' => '音乐描述'])
            ->addColumn('video_title', 'string', ['limit' => 500, 'default' => '', 'comment' => '视频标题'])
            ->addColumn('video_url', 'string', ['limit' => 500, 'default' => '', 'comment' => '视频链接'])
            ->addColumn('video_desc', 'string', ['limit' => 500, 'default' => '', 'comment' => '视频描述'])
            ->addColumn('news_id', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '图文编号'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_by', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '创建用户'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('sort', ['name' => 'idx_wechat_keys_sort'])
            ->addIndex('keys', ['name' => 'idx_wechat_keys_keys'])
            ->addIndex('type', ['name' => 'idx_wechat_keys_type'])
            ->addIndex('time', ['name' => 'idx_wechat_keys_time'])
            ->addIndex('appid', ['name' => 'idx_wechat_keys_appid'])
            ->addIndex('status', ['name' => 'idx_wechat_keys_status'])
            ->save();
    }
}
