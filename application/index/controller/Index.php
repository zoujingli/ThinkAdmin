<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;

/**
 * 网站入口控制器
 * Class Index
 * @package app\index\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/04/05 10:38
 */
class Index extends Controller {

    /**
     * 网站入口
     */
    public function index() {
        $this->redirect('@admin');
    }

}
