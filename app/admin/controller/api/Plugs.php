<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2022 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\service\AdminService;

/**
 * 通用插件管理
 * Class Plugs
 * @package app\admin\controller\api
 */
class Plugs extends Controller
{

    /**
     * 图标选择器
     * @login true
     */
    public function icon()
    {
        $this->title = '图标选择器';
        $this->field = $this->app->request->get('field', 'icon');
        $this->fetch(realpath(__DIR__ . '/../../view/api/icon.html'));
    }

    /**
     * 前端脚本变量
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function script(): \think\Response
    {
        $taDebug = $this->app->isDebug() ? 'true' : 'false';
        $taAdmin = sysuri('admin/index/index', [], false);
        $taEditor = sysconf('base.editor') ?: 'ckeditor4';
        return response(join("\n", [
            "window.taDebug = {$taDebug};",
            "window.taAdmin = '{$taAdmin}';",
            "window.taEditor = '{$taEditor}';",
        ]))->contentType('application/x-javascript');
    }

    /**
     * 优化数据库
     * @login true
     */
    public function optimize()
    {
        if (AdminService::isSuper()) {
            sysoplog('系统运维管理', '创建数据库优化任务');
            $this->_queue('优化数据库所有数据表', 'xadmin:database optimize');
        } else {
            $this->error('只有超级管理员才能操作！');
        }
    }
}