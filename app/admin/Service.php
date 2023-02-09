<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

namespace app\admin;

use think\admin\Plugin;

/**
 * 插件服务注册
 * Class Service
 * @package app\admin
 */
class Service extends Plugin
{
    /**
     * 定义资源目录
     * @var string
     */
    protected $appCopy = 'app/admin';

    /**
     * 定义安装包名称
     * @var string
     */
    protected $package = 'zoujingli/think-plugs-admin';

    /**
     * 定义插件中心菜单
     * @return array
     */
    public static function menu(): array
    {
        return [];
    }
}