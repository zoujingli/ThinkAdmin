<?php

namespace app\center\controller;

use think\admin\Controller;

/**
 * 应用插件中心
 * Class Index
 * @package app\center\contrller
 */
class Index extends Controller
{
    /**
     * 显示插件中心
     * @auth true
     * @menu true
     * @return void
     */
    public function index()
    {
        $this->fetch();
    }
}