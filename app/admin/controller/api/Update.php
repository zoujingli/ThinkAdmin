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

/**
 * 安装服务端支持
 * Class Update
 * @package app\admin\controller\api
 */
class Update extends Controller
{
    /**
     * 读取文件内容
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
     * 获取模块版本
     */
    public function version()
    {
        $input = $this->_vali(['module.require' => '模块名称不能为空！']);
        $filename = $this->app->getRootPath() . 'app' . DIRECTORY_SEPARATOR . $input['module'] . DIRECTORY_SEPARATOR . 'ver.php';
        if (file_exists($filename) && is_file($filename) && is_array($vars = include $filename)) {
            if (isset($vars['name']) && isset($vars['version']) && isset($vars['content']) && isset($vars['changes'])) {
                $this->success('获取模块版本成功！', $vars);
            } else {
                $this->error('获取模块版本失败！');
            }
        } else {
            $this->error('获取的模块无效！');
        }
    }

    /**
     * 读取文件列表
     */
    public function node()
    {
        $this->success('获取文件列表成功！', InstallService::instance()->getList(
            json_decode($this->request->post('rules', '[]', ''), true),
            json_decode($this->request->post('ignore', '[]', ''), true)
        ));
    }

}