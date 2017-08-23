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

namespace app\demo\controller;

use think\Controller;

/**
 * 系统权限管理控制器
 * Class Plugs
 * @package app\demo\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/07/10 18:13
 */
class Plugs extends Controller
{


    /**
     * 文件上传
     * @return \think\response\View
     */
    public function file()
    {
        return view('', ['title' => '文件上传']);
    }

    /**
     * 省市区插件
     * @return \think\response\View
     */
    public function region()
    {
        return view('', ['title' => '省市区插件']);
    }

    /**
     * 富文本编辑器
     * @return \think\response\View
     */
    public function editor()
    {
        return view('', ['title' => '富文本编辑器']);
    }
}
