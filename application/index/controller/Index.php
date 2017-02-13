<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller {

    public function index() {
        $this->redirect('@admin');
        $version = Db::query('select version() as ver');
        $version = array_pop($version);
        $this->assign('mysql_ver', $version['ver']);
        return view();
    }
}
