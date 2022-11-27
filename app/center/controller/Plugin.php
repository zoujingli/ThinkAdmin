<?php

namespace app\center\controller;

use think\admin\Controller;

/**
 * 在线插件管理
 * Class Plugin
 * @package app\center\controller
 */
class Plugin extends Controller
{
    /**
     * 在线插件管理
     * @auth true
     * @menu true
     * @return void
     */
    public function index()
    {
        $this->fetch();
    }
}