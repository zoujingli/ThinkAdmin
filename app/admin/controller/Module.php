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

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\service\ModuleService;

/**
 * 系统模块管理
 * Class Module
 * @package app\admin\controller
 */
class Module extends Controller
{
    /**
     * 系统模块管理
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '系统模块管理';
        $this->modules = ModuleService::change();
        $this->fetch();
    }

    /**
     * 安装更新模块
     * @auth true
     */
    public function install()
    {
        $data = $this->_vali(['name.require' => '模块名称不能为空！']);
        [$state, $message] = ModuleService::install($data['name']);
        $state ? $this->success($message) : $this->error($message);
    }

    /**
     * 查看模块更新
     * @auth true
     */
    public function change()
    {
        $data = $this->_vali(['name.require' => '模块名称不能为空！']);
        $online = ModuleService::online();
        $locals = ModuleService::getModules();
        if (isset($online[$data['name']])) {
            $this->module = $online[$data['name']];
            $this->current = $locals[$data['name']] ?? [];
            $pattern = "|^(\d{4})\.(\d{2})\.(\d{2})\.(\d+)$|";
            $this->module['change'] = array_reverse($this->module['change']);
            foreach ($this->module['change'] as $version => &$change) {
                $change = ['content' => $change, 'version' => preg_replace($pattern, '$1年$2月$3日 更新', $version)];
            }
            $this->fetch();
        } else {
            $this->error('未查询到模块更新记录！');
        }
    }
}