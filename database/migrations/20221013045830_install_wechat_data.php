<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

use app\wechat\Service;
use think\admin\extend\PhinxExtend;
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
        set_time_limit(0);
        @ini_set('memory_limit', -1);

        $this->insertMenu();
    }

    /**
     * 初始化菜单
     */
    private function insertMenu()
    {
        // 写入微信菜单
        PhinxExtend::write2menu([
            [
                'name' => '微信管理',
                'sort' => '200',
                'subs' => Service::menu(),
            ],
        ], ['node' => 'wechat/config/options']);
    }
}
