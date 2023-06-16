<?php

// +----------------------------------------------------------------------
// | Admin Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-admin
// | github 代码仓库：https://github.com/zoujingli/think-plugs-admin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\service\AdminService;
use think\Response;

/**
 * 扩展插件管理
 * @class Plugs
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
        // 读取 layui 字体图标
        if (empty($this->layuiIcons = $this->app->cache->get('LayuiIcons', []))) {
            $style = file_get_contents(syspath('public/static/plugs/layui/css/layui.css'));
            if (preg_match_all('#\.(layui-icon-[\w-]+):#', $style, $matches)) {
                if (count($this->layuiIcons = $matches[1]) > 0) {
                    $this->app->cache->set('LayuiIcons', $this->layuiIcons, 60);
                }
            }
        }
        // 读取自定义字体图标
        if (empty($this->thinkIcons = $this->app->cache->get('ThinkAdminSelfIcons', []))) {
            $style = file_get_contents(syspath('public/static/theme/css/iconfont.css'));
            if (preg_match_all('#\.(iconfont-[\w-]+):#', $style, $matches)) {
                if (count($this->thinkIcons = $matches[1]) > 0) {
                    $this->app->cache->set('ThinkAdminSelfIcons', $this->thinkIcons, 60);
                }
            }
        }
        $this->field = $this->app->request->get('field', 'icon');
        $this->fetch(realpath(__DIR__ . '/../../view/api/icon.html'));
    }

    /**
     * 前端脚本变量
     * @return \think\Response
     * @throws \think\admin\Exception
     */
    public function script(): Response
    {
        $token = $this->request->get('uptoken', '');
        $domain = boolval(AdminService::withUploadUnid($token));
        return response(join("\r\n", [
            sprintf("window.taDebug = %s;", $this->app->isDebug() ? 'true' : 'false'),
            sprintf("window.taAdmin = '%s';", sysuri('admin/index/index', [], false, $domain)),
            sprintf("window.taEditor = '%s';", sysconf('base.editor|raw') ?: 'ckeditor4'),
        ]))->contentType('application/javascript');
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
            $this->error('请使用超管账号操作！');
        }
    }
}