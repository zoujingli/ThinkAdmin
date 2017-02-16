<?php

namespace app\admin\controller;

use controller\BasicAdmin;

/**
 * 系统角色管理控制器
 * Class Role
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:14
 */
class Role extends BasicAdmin {

    protected $table = 'SystemRole';

    public function index() {
        parent::_list($this->table);
    }

}
