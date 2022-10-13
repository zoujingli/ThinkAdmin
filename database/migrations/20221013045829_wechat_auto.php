<?php

use think\migration\Migrator;

/**
 * 微信回复数据
 */
class WechatAuto extends Migrator
{
    private $name = 'wechat_auto';

    public function change()
    {
        // 存在则跳过
        if ($this->hasTable($this->name)) {
            return;
        }
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '微信-回复',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '类型(text,image,news)'])
            ->addColumn('time', 'string', ['limit' => 50, 'default' => '', 'comment' => '延迟时间'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '消息编号'])
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
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_wechat_auto_code'])
            ->addIndex('type', ['name' => 'idx_wechat_auto_type'])
            ->addIndex('time', ['name' => 'idx_wechat_auto_time'])
            ->addIndex('appid', ['name' => 'idx_wechat_auto_appid'])
            ->addIndex('status', ['name' => 'idx_wechat_auto_status'])
            ->save();
    }
}
