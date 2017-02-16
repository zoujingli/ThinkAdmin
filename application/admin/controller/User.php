<?php
namespace app\admin\controller;

use controller\BasicAdmin;

/**
 * 系统用户管理控制器
 * Class User
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:12
 */
class User extends BasicAdmin {

    protected $table = 'SystemUser';

    public function index() {
        parent::_list($this->table);
    }

}