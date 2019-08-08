<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\service;

use library\tools\Node;
use think\Db;
use think\facade\Request;

/**
 * 系统日志服务管理
 * Class LogService
 * @package app\admin\service
 */
class OplogService
{
    /**
     * 写入操作日志
     * @param string $action
     * @param string $content
     * @return bool
     */
    public static function write($action = '行为', $content = "内容描述")
    {
        return Db::name('SystemLog')->insert([
            'node'     => Node::current(), 'action' => $action, 'content' => $content,
            'geoip'    => PHP_SAPI === 'cli' ? '127.0.0.1' : Request::ip(),
            'username' => PHP_SAPI === 'cli' ? 'cli' : (string)session('admin_user.username'),
        ]);
    }

    /**
     * 清理系统日志
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function clear()
    {
        return Db::name('SystemLog')->where('1=1')->delete() !== false;
    }
}
