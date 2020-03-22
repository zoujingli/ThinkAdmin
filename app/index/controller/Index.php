<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\admin\Controller;
use think\admin\service\QueueService;

/**
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    public function index()
    {
        $this->redirect(url('@admin/login'));
    }

    /**
     * 创建测试进度任务
     * @param null $code
     * @throws \think\Exception
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function test($code = null)
    {
        if (empty($code)) {
            $code = sysqueue('测试', 'xadmin:tests');
            $this->redirect(url("@index/index/test/code/{$code}"));
        }
        dump(QueueService::instance()->progress($code));
    }
}