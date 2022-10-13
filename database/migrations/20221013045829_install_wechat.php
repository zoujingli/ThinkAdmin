<?php

use think\migration\Migrator;

/**
 * 微信模块数据表
 */
class InstallWechat extends Migrator
{
    public function change()
    {
        $this->_auto();
        $this->_fans();
        $this->_tags();
        $this->_keys();
        $this->_news();
        $this->_media();
        $this->_article();
    }

    private function _auto()
    {
        // 当前操作
        $table = 'wechat_auto';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
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

    private function _fans()
    {
        // 当前操作
        $table = 'wechat_fans';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '微信-粉丝',
        ])
            ->addColumn('appid', 'string', ['limit' => 50, 'default' => '', 'comment' => '公众号编号'])
            ->addColumn('unionid', 'string', ['limit' => 100, 'default' => '', 'comment' => 'UNIONID'])
            ->addColumn('openid', 'string', ['limit' => 100, 'default' => '', 'comment' => 'OPENID'])
            ->addColumn('tagid_list', 'string', ['limit' => 100, 'default' => '', 'comment' => '粉丝标签'])
            ->addColumn('is_black', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '黑名单状态'])
            ->addColumn('subscribe', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '黑名单状态'])
            ->addColumn('nickname', 'string', ['limit' => 200, 'default' => '', 'comment' => '用户昵称'])
            ->addColumn('sex', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '用户性别(1男性,2女性,0未知)'])
            ->addColumn('country', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户所在国家'])
            ->addColumn('province', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户所在省份'])
            ->addColumn('city', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户所在城市'])
            ->addColumn('language', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户的语言'])
            ->addColumn('headimgurl', 'string', ['limit' => 500, 'default' => '', 'comment' => '用户头像'])
            ->addColumn('subscribe_time', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '关注时间'])
            ->addColumn('subscribe_at', 'datetime', ['limit' => 20, 'default' => null, 'comment' => '关注时间'])
            ->addColumn('subscribe_scene', 'string', ['limit' => 200, 'default' => '', 'comment' => '扫码场景'])
            ->addColumn('qr_scene', 'string', ['limit' => 200, 'default' => '', 'comment' => '场景数值'])
            ->addColumn('qr_scene_str', 'string', ['limit' => 200, 'default' => '', 'comment' => '场景内容'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'comment' => '用户备注'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('appid', ['name' => 'idx_wechat_fans_appid'])
            ->addIndex('openid', ['name' => 'idx_wechat_fans_openid'])
            ->addIndex('unionid', ['name' => 'idx_wechat_fans_unionid'])
            ->addIndex('is_black', ['name' => 'idx_wechat_fans_black'])
            ->addIndex('subscribe', ['name' => 'idx_wechat_fans_subscribe'])
            ->save();
    }

    private function _tags()
    {
        // 当前操作
        $table = 'wechat_fans_tags';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
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

    private function _keys()
    {
        // 当前操作
        $table = 'wechat_keys';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
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

    private function _media()
    {
        // 当前操作
        $table = 'wechat_media';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
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

    private function _news()
    {
        // 当前操作
        $table = 'wechat_news';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
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

    private function _article()
    {
        // 当前操作
        $table = 'wechat_news_article';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
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
