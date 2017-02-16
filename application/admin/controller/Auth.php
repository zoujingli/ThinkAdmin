<?php
namespace app\admin\controller;

use controller\BasicAdmin;

/**
 * 系统权限管理控制器
 * Class Auth
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:13
 */
class Auth extends BasicAdmin {

    protected $table = 'SystemAuth';

    public function index() {
        $this->title = '系统权限管理';
        parent::_list($this->table);
    }

}