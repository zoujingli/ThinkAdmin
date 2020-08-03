<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\api;

use think\admin\Controller;
use think\admin\service\InstallService;
use think\admin\service\NodeService;

/**
 * 安装服务端支持
 * Class Update
 * @package app\admin\controller\api
 */
class Update extends Controller
{

    /**
     * 获取模块信息
     */
    public function version()
    {
        $input = $this->_vali(['name.default' => '_all']);
        if ($input['name'] === '_all') {
            $data = [];
            foreach (NodeService::instance()->getModules() as $module) {
                if (is_array($ver = $this->__getModuleVersion($module))) $data[] = $ver;
            }
            $this->success('获取所有模块版本成功！', $data);
        } else {
            $ver = $this->__getModuleVersion($input['name']);
            if ($ver === null) $this->error('获取模块版本失败！');
            if ($ver === false) $this->error('获取模块信息无效！');
            if (is_array($ver)) $this->success('获取模块版本成功！', [$ver]);
        }
    }

    /**
     * 获取模块版本信息
     * @param string $name
     * @return bool|array|null
     */
    private function __getModuleVersion($name)
    {
        $file = $this->app->getBasePath() . $name . DIRECTORY_SEPARATOR . 'ver.php';
        if (file_exists($file) && is_file($file) && is_array($vars = @include $file)) {
            return (isset($vars['name']) && isset($vars['version']) && isset($vars['changes'])) ? $vars : null;
        } else {
            return false;
        }
    }

    /**
     * 读取文件内容（旧版本）
     */
    public function get()
    {
        if (file_exists($file = $this->app->getRootPath() . decode(input('encode', '0')))) {
            $this->success('读取文件成功！', ['content' => base64_encode(file_get_contents($file))]);
        } else {
            $this->error('读取文件内容失败！');
        }
    }

    /**
     * 读取文件列表（旧版本）
     */
    public function node()
    {
        $this->success('获取文件列表成功！', InstallService::instance()->getList(
            json_decode($this->request->post('rules', '[]', ''), true),
            json_decode($this->request->post('ignore', '[]', ''), true)
        ));
    }

}