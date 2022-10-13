<?php

use think\migration\Migrator;

/**
 * 微信素材数据
 */
class WechatMedia extends Migrator
{
    private $name = 'wechat_media';

    public function change()
    {
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '微信-素材',
        ])
            ->addColumn('md5', 'string', ['limit' => 32, 'default' => '', 'comment' => '文件哈希'])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '媒体类型'])
            ->addColumn('appid', 'string', ['limit' => 50, 'default' => '', 'comment' => '公众号编号'])
            ->addColumn('media_id', 'string', ['limit' => 100, 'default' => '', 'comment' => '永久素材MediaID'])
            ->addColumn('local_url', 'string', ['limit' => 500, 'default' => '', 'comment' => '本地文件链接'])
            ->addColumn('media_url', 'string', ['limit' => 500, 'default' => '', 'comment' => '远程图片链接'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('md5', ['name' => 'idx_wechat_media_md5'])
            ->addIndex('type', ['name' => 'idx_wechat_media_type'])
            ->addIndex('appid', ['name' => 'idx_wechat_media_appid'])
            ->addIndex('media_id', ['name' => 'idx_wechat_media_id'])
            ->save();
    }
}
