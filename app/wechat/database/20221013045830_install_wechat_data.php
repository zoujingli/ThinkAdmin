<?php

use think\admin\extend\ToolsExtend;
use think\migration\Migrator;

/**
 * 微信初始化
 */
class InstallWechatData extends Migrator
{
    /**
     * 初始化数据
     * @return void
     */
    public function change()
    {
        $this->insertMenu();
    }

    /**
     * 初始化菜单
     */
    private function insertMenu()
    {
        // 写入微信菜单
        ToolsExtend::write2menu([
            [
                'name' => '微信管理',
                'sort' => '200',
                'subs' => [
                    [
                        'name' => '微信管理',
                        'subs' => [
                            ['name' => '微信接口配置', 'icon' => 'layui-icon layui-icon-set', 'node' => 'wechat/config/options'],
                            ['name' => '微信支付配置', 'icon' => 'layui-icon layui-icon-rmb', 'node' => 'wechat/config/payment'],
                        ],
                    ],
                    [
                        'name' => '微信定制',
                        'subs' => [
                            ['name' => '微信粉丝管理', 'icon' => 'layui-icon layui-icon-username', 'node' => 'wechat/fans/index'],
                            ['name' => '微信图文管理', 'icon' => 'layui-icon layui-icon-template-1', 'node' => 'wechat/news/index'],
                            ['name' => '微信菜单配置', 'icon' => 'layui-icon layui-icon-cellphone', 'node' => 'wechat/menu/index'],
                            ['name' => '回复规则管理', 'icon' => 'layui-icon layui-icon-engine', 'node' => 'wechat/keys/index'],
                            ['name' => '关注自动回复', 'icon' => 'layui-icon layui-icon-release', 'node' => 'wechat/auto/index'],
                        ],
                    ],
                ],
            ],
        ], ['node' => 'wechat/config/options']);
    }
}
