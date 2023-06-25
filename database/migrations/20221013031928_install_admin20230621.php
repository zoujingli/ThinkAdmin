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

use think\migration\Migrator;

@set_time_limit(0);
@ini_set('memory_limit', -1);

/**
 * 系统模块数据
 */
class InstallAdmin20230621 extends Migrator
{
    public function change()
    {
        // 当前数据表
        $table = 'system_queue';
        // 检查与更新数据表
        $this->table($table)->hasColumn('message') || $this->table($table)
            ->addColumn('message', 'text', ['default' => NULL, 'null' => true, 'after' => 'attempts', 'comment' => '最新消息'])
            ->update();
    }
}
