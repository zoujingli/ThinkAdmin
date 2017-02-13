<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use think\Db;

class Index extends BasicAdmin {

    public function index() {
        $this->assign('ptitle', '后台管理');
        return view();
    }

    public function main() {
        $version = Db::query('select version() as ver');
        $version = array_pop($version);
        $this->assign('mysql_ver', $version['ver']);
        return view();
    }

}