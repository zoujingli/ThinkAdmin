<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\logic;

use library\Controller;
use think\Db;

/**
 * 基础视图管理器
 * Class Logic
 * @package library\view
 */
abstract class Logic
{
    /**
     * 数据库操作对象
     * @var \think\db\Query
     */
    protected $query;

    /**
     * 当前操作控制器引用
     * @var \library\Controller
     */
    public $controller;

    /**
     * 逻辑器初始化
     * @param Controller $controller
     * @return mixed
     */
    abstract public function init(Controller $controller);

    /**
     * 获取数据库查询对象
     * @param string|\think\db\Query $dbQuery
     * @return \think\db\Query
     */
    protected function buildQuery($dbQuery)
    {
        return is_string($dbQuery) ? Db::name($dbQuery) : $dbQuery;
    }

}