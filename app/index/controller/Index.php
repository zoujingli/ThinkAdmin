<?php

// +----------------------------------------------------------------------
// | Static Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon<zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-static
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\admin\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->redirect(sysuri('admin/login/index'));
    }
}
