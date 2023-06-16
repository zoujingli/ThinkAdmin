<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

declare(strict_types=1);

namespace app\admin;

use think\admin\Plugin;

/**
 * 插件服务注册
 * @class Service
 * @package app\admin
 */
class Service extends Plugin
{
    /**
     * 定义插件名称
     * @var string
     */
    protected $appName = '系统管理';

    /**
     * 定义安装包名
     * @var string
     */
    protected $package = 'zoujingli/think-plugs-admin';

    /**
     * 定义插件中心菜单
     * @return array
     */
    public static function menu(): array
    {
        return [
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
        ];
    }
}