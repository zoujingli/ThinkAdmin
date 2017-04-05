<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

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
