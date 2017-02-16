<?php

namespace app\admin\controller;

use controller\BasicAdmin;

/**
 * 后台参数配置控制器
 * Class Config
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:05
 */
class Config extends BasicAdmin {

    protected $table = 'SystemConfig';

    public function index() {
        parent::_list($this->table);
    }

}
