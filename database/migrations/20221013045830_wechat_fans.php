<?php

use think\migration\Migrator;

/**
 * 微信粉丝数据
 */
class WechatFans extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = 'wechat_fans';

        // 存在则跳过
        if ($this->hasTable($table)) {
            return;
        }

        // 创建数据表
        $this->table($table, [
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
}
