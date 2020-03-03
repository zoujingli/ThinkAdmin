<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace library;

use think\App;
use think\Container;
use think\Db;
use think\db\Query;

/**
 * Class Helper
 * @package library
 */
abstract class Helper
{
    /**
     * 当前应用容器
     * @var App
     */
    public $app;

    /**
     * 数据库实例
     * @var Query
     */
    public $query;

    /**
     * 当前控制器实例
     * @var Controller
     */
    public $controller;

    /**
     * Helper constructor.
     * @param App $app
     * @param Controller $controller
     */
    public function __construct(App $app, Controller $controller)
    {
        $this->app = $app;
        $this->controller = $controller;
    }

    /**
     * 获取数据库对象
     * @param string|Query $dbQuery
     * @return Query
     */
    protected function buildQuery($dbQuery)
    {
        return is_string($dbQuery) ? Db::name($dbQuery) : $dbQuery;
    }

    /**
     * 实例对象反射
     * @return static
     */
    public static function instance()
    {
        return Container::getInstance()->invokeClass(static::class);
    }

}