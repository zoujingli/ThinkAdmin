<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace think\admin;

use think\admin\service\AuthService;
use think\middleware\SessionInit;
use think\Request;
use think\Service;

/**
 * 模块注册服务
 * Class Library
 * @package think\admin
 */
class Library extends Service
{
    /**
     * 注册服务
     */
    public function register()
    {
        if (PHP_SAPI !== 'cli') {
            // 注册会话中间键
            $this->app->middleware->add(SessionInit::class);
            // 注册访问中间键
            $this->app->middleware->add(function (Request $request, \Closure $next) {
                $header = [];
                if (($origin = $request->header('origin', '*')) !== '*') {
                    $header['Access-Control-Allow-Origin'] = $origin;
                    $header['Access-Control-Allow-Methods'] = 'GET,POST,PATCH,PUT,DELETE';
                    $header['Access-Control-Allow-Headers'] = 'Authorization,Content-Type,If-Match,If-Modified-Since,If-None-Match,If-Unmodified-Since,X-Requested-With';
                    $header['Access-Control-Expose-Headers'] = 'User-Form-Token,User-Token,Token';
                }
                // 访问模式及访问权限检查
                if ($request->isOptions()) {
                    return response()->code(204)->header($header);
                } elseif (AuthService::instance()->check()) {
                    return $next($request)->code(200)->header($header);
                } elseif (AuthService::instance()->isLogin()) {
                    return json(['code' => 0, 'msg' => '抱歉，没有访问该操作的权限！'])->header($header);
                } else {
                    return json(['code' => 0, 'msg' => '抱歉，需要登录获取访问权限！', 'url' => url('@admin/login')->build()])->header($header);
                }
            }, 'route');
        }
        // 动态加入应用函数
        foreach (glob($this->app->getAppPath() . '*/sys.php') as $file) {
            \Composer\Autoload\includeFile($file);
        }
    }

    /**
     * 启动服务
     */
    public function boot()
    {
        // 注册系统任务指令
        $this->commands([
            'think\admin\queue\WorkQueue',
            'think\admin\queue\StopQueue',
            'think\admin\queue\StateQueue',
            'think\admin\queue\StartQueue',
            'think\admin\queue\QueryQueue',
            'think\admin\queue\ListenQueue',
            'think\admin\command\Install',
        ]);
    }
}