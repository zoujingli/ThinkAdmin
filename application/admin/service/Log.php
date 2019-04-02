<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\service;

use library\tools\Node;
use think\Db;

/**
 * 系统日志服务管理
 * Class Log
 * @package app\admin\service
 */
class Log
{
    /**
     * 写入操作日志
     * @param string $action
     * @param string $content
     * @return bool
     */
    public static function write($action = '行为', $content = "内容描述")
    {
        $data = [
            'node'     => Node::current(),
            'geoip'    => PHP_SAPI === 'cli' ? '127.0.0.1' : request()->ip(),
            'action'   => $action,
            'content'  => $content,
            'username' => PHP_SAPI === 'cli' ? 'cli' : session('user.username'),
        ];
        return Db::name('SystemLog')->insert($data) !== false;
    }

    /**
     * 清理系统日志数据
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function clear()
    {
        return Db::name('SystemLog')->where('1=1')->delete() !== false;
    }
}