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

namespace hook;

use think\Config;
use think\Db;
use think\exception\HttpResponseException;
use think\Request;
use think\View;

/**
 * 访问权限管理
 * Class AccessAuth
 * @package hook
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/05/12 11:59
 */
class AccessAuth
{

    /**
     * 当前请求对象
     * @var Request
     */
    protected $request;

    /**
     * 行为入口
     * @param $params
     */
    public function run(&$params)
    {
        $this->request = Request::instance();
        list($module, $controller, $action) = [$this->request->module(), $this->request->controller(), $this->request->action()];
        $node = strtolower("{$module}/{$controller}/{$action}");
        $info = Db::name('SystemNode')->where('node', $node)->find();
        $access = [
            'is_menu'  => intval(!empty($info['is_menu'])),
            'is_auth'  => intval(!empty($info['is_auth'])),
            'is_login' => empty($info['is_auth']) ? intval(!empty($info['is_login'])) : 1
        ];
        // 用户登录状态检查
        if (!empty($access['is_login']) && !session('user')) {
            if ($this->request->isAjax()) {
                $this->response('抱歉，您还没有登录获取访问权限！', 0, url('@admin/login'));
            }
            throw new HttpResponseException(redirect('@admin/login'));
        }
        // 访问权限节点检查
        if (!empty($access['is_auth']) && !auth($node)) {
            $this->response('抱歉，您没有访问该模块的权限！', 0);
        }
        // 权限正常, 默认赋值
        $view = View::instance(Config::get('template'), Config::get('view_replace_str'));
        $view->assign('classuri', strtolower("{$module}/{$controller}"));
    }

    /**
     * 返回消息对象
     * @param string $msg 消息内容
     * @param int $code 返回状态码
     * @param string $url 跳转URL地址
     * @param array $data 数据内容
     * @param int $wait
     */
    protected function response($msg, $code = 0, $url = '', $data = [], $wait = 3)
    {
        $result = ['code' => $code, 'msg' => $msg, 'data' => $data, 'url' => $url, 'wait' => $wait];
        throw new HttpResponseException(json($result));
    }

}
