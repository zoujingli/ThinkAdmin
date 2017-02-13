<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use think\Db;

class Index extends BasicAdmin {

    public function index() {
        $version = Db::query('select version() as ver');
        $version = array_pop($version);
        $this->assign('mysql_ver', $version['ver']);
        return view();
    }

}