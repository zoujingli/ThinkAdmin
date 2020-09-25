<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

use think\admin\service\AdminService;
use think\admin\service\SystemService;
use think\helper\Str;

try {
    /*! 全局数据变更数据 */
    $GLOBALS['oplogs'] = [];
    /*! 数据变更日志开关状态 */
    if (sysconf('base.oplog_state') > 0) {
        /*! 数据变更批量写入 */
        app()->event->listen('HttpEnd', function () {
            if (is_array($GLOBALS['oplogs']) && count($GLOBALS['oplogs']) > 0) {
                foreach (array_chunk($GLOBALS['oplogs'], 100) as $items) {
                    app()->db->name('SystemOplog')->insertAll($items);
                }
                $GLOBALS['oplogs'] = [];
                $days = floatval(sysconf('base.oplog_days'));
                if (rand(1, 100) <= 10 && $days > 0) {
                    $lastdate = date('Y-m-d H:i:s', strtotime("-{$days}days"));
                    app()->db->name('SystemOplog')->where('create_at', '<', $lastdate)->delete();
                }
            }
        });
        /*! 数据操作SQL语句监听分析 */
        app()->db->listen(function ($sqlstr) {
            [$type] = explode(' ', $sqlstr);
            if (in_array($type, ['INSERT', 'UPDATE', 'DELETE']) && AdminService::instance()->isLogin()) {
                [$sqlstr] = explode('GROUP BY', explode('ORDER BY', $sqlstr)[0]);
                if (preg_match('/^INSERT\s+INTO\s+`(.*?)`\s+SET\s+(.*?)\s*$/i', $sqlstr, $matches)) {
                    if (stripos($matches[1] = Str::studly($matches[1]), 'SystemOplog') === false) {
                        $matches[2] = substr(str_replace(['`', '\''], '', $matches[2]), 0, 800);
                        $GLOBALS['oplogs'][] = SystemService::instance()->getOplog("添加 {$matches[1]} 数据", $matches[2]);
                    }
                } elseif (preg_match('/^INSERT\s*INTO\s+`(.*?)`\s+(.*?)\s+VALUES\s+(.*?)\s*$/i', $sqlstr, $matches)) {
                    if (stripos($matches[1] = Str::studly($matches[1]), 'SystemOplog') === false) {
                        $matches[2] = substr(str_replace(['`', '\''], '', $matches[2]), 0, 200);
                        $matches[3] = substr(str_replace(['`', '\''], '', $matches[3]), 0, 600);
                        $GLOBALS['oplogs'][] = SystemService::instance()->getOplog("添加 {$matches[1]} 数据", "{$matches[2]} VALUES {$matches[3]}");
                    }
                } elseif (preg_match('/^UPDATE\s+`(.*?)`\s+SET\s+(.*?)\s+WHERE\s+(.*?)\s*$/i', $sqlstr, $matches)) {
                    if (stripos($matches[1] = Str::studly($matches[1]), 'SystemOplog') === false) {
                        $matches[3] = substr(str_replace(['`', '\''], '', $matches[3]), 0, 150);
                        $matches[2] = substr(str_replace(['`', '\''], '', $matches[2]), 0, 800);
                        $GLOBALS['oplogs'][] = SystemService::instance()->getOplog("更新 {$matches[1]} 数据 {$matches[3]}", $matches[2]);
                    }
                } elseif (preg_match('/^DELETE\s*FROM\s*`(.*?)`\s*WHERE\s*(.*?)\s*$/i', $sqlstr, $matches)) {
                    if (stripos($matches[1] = Str::studly($matches[1]), 'SystemOplog') === false) {
                        $matches[2] = str_replace(['`', '\''], '', $matches[2]);
                        $GLOBALS['oplogs'][] = SystemService::instance()->getOplog("删除 {$matches[1]} 数据 {$matches[2]}", "");
                    }
                }
            }
        });
    }
} catch (\Exception $exception) {
    app()->log->error($exception->getMessage());
}