<?php

use think\admin\extend\ToolsExtend;
use think\admin\model\SystemConfig;
use think\admin\model\SystemUser;
use think\migration\Migrator;

/**
 * 系统模块初始化
 */
class InstallAdminData extends Migrator
{
    /**
     * 数据库初始化
     * @return void
     * @throws \think\db\exception\DbException
     */
    public function change()
    {
        $this->createUser();
        $this->createMenu();
        $this->createConf();
    }

    /**
     * 初始化用户数据
     * @return void
     * @throws \think\db\exception\DbException
     */
    private function createUser()
    {
        // 检查是否存在
        $map = ['username' => 'admin'];
        if (SystemUser::mk()->where($map)->count() > 0) {
            return;
        }

        // 初始化默认数据
        SystemUser::mk()->save([
            'id'       => 10000,
            'username' => 'admin',
            'nickname' => '超级管理员',
            'password' => '21232f297a57a5a743894a0e4a801fc3',
            'headimg'  => 'https://thinkadmin.top/static/img/icon.png',
        ]);
    }

    /**
     * 初始化系统菜单
     * @return void
     */
    private function createMenu()
    {
        // 初始化菜单数据
        ToolsExtend::write2menu([
            [
                'name' => '系统管理',
                'sort' => '100',
                'subs' => [
                    [
                        'name' => '系统配置',
                        'subs' => [
                            ['name' => '系统参数配置', 'icon' => 'layui-icon layui-icon-set', 'node' => 'admin/config/index'],
                            ['name' => '系统任务管理', 'icon' => 'layui-icon layui-icon-log', 'node' => 'admin/queue/index'],
                            ['name' => '系统日志管理', 'icon' => 'layui-icon layui-icon-form', 'node' => 'admin/oplog/index'],
                            ['name' => '数据字典管理', 'icon' => 'layui-icon layui-icon-code-circle', 'node' => 'admin/base/index'],
                            ['name' => '系统文件管理', 'icon' => 'layui-icon layui-icon-carousel', 'node' => 'admin/file/index'],
                            ['name' => '系统菜单管理', 'icon' => 'layui-icon layui-icon-layouts', 'node' => 'admin/menu/index'],
                        ],
                    ],
                    [
                        'name' => '权限管理',
                        'subs' => [
                            ['name' => '访问权限管理', 'icon' => 'layui-icon layui-icon-vercode', 'node' => 'admin/auth/index'],
                            ['name' => '系统用户管理', 'icon' => 'layui-icon layui-icon-username', 'node' => 'admin/user/index'],
                        ],
                    ],
                ],
            ],
        ], ['node' => 'admin/config/index']);
    }

    /**
     * 初始化配置参数
     * @return void
     * @throws \think\db\exception\DbException
     */
    private function createConf()
    {
        if (SystemConfig::mk()->count()) {
            return;
        }
        SystemConfig::mk()->insertAll([
            ['type' => 'base', 'name' => 'app_name', 'value' => 'ThinkAdmin'],
            ['type' => 'base', 'name' => 'app_version', 'value' => 'v6'],
            ['type' => 'base', 'name' => 'editor', 'value' => 'ckeditor5'],
            ['type' => 'base', 'name' => 'login_name', 'value' => '系统管理'],
            ['type' => 'base', 'name' => 'site_copy', 'value' => '©版权所有 2014-' . date('Y') . ' 楚才科技'],
            ['type' => 'base', 'name' => 'site_icon', 'value' => 'https://v6.thinkadmin.top/upload/4b/5a423974e447d5502023f553ed370f.png'],
            ['type' => 'base', 'name' => 'site_name', 'value' => 'ThinkAdmin'],
            ['type' => 'base', 'name' => 'site_theme', 'value' => 'default'],
            ['type' => 'storage', 'name' => 'allow_exts', 'value' => 'doc,gif,ico,jpg,mp3,mp4,p12,pem,png,zip,rar,xls,xlsx'],
            ['type' => 'storage', 'name' => 'type', 'value' => 'local'],
            ['type' => 'wechat', 'name' => 'type', 'value' => 'api'],
        ]);
    }
}
