<?php

namespace app\admin\model;

use think\admin\Model;

/**
 * 系统菜单模型
 * Class SystemMenu
 * @package app\admin\model
 */
class SystemMenu extends Model
{
    /**
     * 日志名称
     * @var string
     */
    protected $oplogName = '系统菜单';

    /**
     * 日志类型
     * @var string
     */
    protected $oplogType = '系统菜单管理';
}