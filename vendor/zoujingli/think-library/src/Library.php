<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin;

use Closure;
use think\admin\command\Database;
use think\admin\command\Install;
use think\admin\command\Queue;
use think\admin\command\Replace;
use think\admin\command\Version;
use think\admin\multiple\BuildUrl;
use think\admin\multiple\command\Build;
use think\admin\multiple\Multiple;
use think\admin\service\AdminService;
use think\admin\service\SystemService;
use think\middleware\LoadLangPack;
use think\middleware\SessionInit;
use think\Request;
use think\Service;
use function Composer\Autoload\includeFile;

/**
 * 模块注册服务
 * Class Library
 * @package think\admin
 */
class Library extends Service
{
    /**
     * 版本号
     */
    const VERSION = '6.0.23';

    /**
     * 启动服务
     */
    public function boot()
    {
        // 服务初始化处理
        $this->app->event->listen('HttpRun', function (Request $request) {
            // 配置默认输入过滤
            $request->filter(['trim']);
            // 注册多应用中间键
            $this->app->middleware->add(Multiple::class);
            // 判断访问模式兼容处理
            if ($request->isCli()) {
                // 兼容 CLI 访问控制器
                if (empty($_SERVER['REQUEST_URI']) && isset($_SERVER['argv'][1])) {
                    $request->setPathinfo($_SERVER['argv'][1]);
                }
            } else {
                // 兼容 HTTP 调用 Console 后 URL 问题
                $request->setHost($request->host());
            }
        });
        // 替换 ThinkPHP 地址
        $this->app->bind('think\route\Url', BuildUrl::class);
        // 替换 ThinkPHP 指令
        $this->commands(['build' => Build::class]);
        // 注册 ThinkAdmin 指令
        $this->commands([Queue::class, Install::class, Version::class, Database::class, Replace::class]);
        // 动态应用运行参数
        SystemService::instance()->bindRuntime();
    }

    /**
     * 初始化服务
     */
    public function register()
    {
        // 加载中文语言
        $this->app->lang->load(__DIR__ . '/lang/zh-cn.php', 'zh-cn');
        $this->app->lang->load(__DIR__ . '/lang/en-us.php', 'en-us');
        // 终端 HTTP 访问时特殊处理
        if (!$this->app->request->isCli()) {
            // 如果是 YAR 接口或指定情况下，不需要初始化会话和语言包，否则有可能会报错
            $isYarRpc = stripos($this->app->request->header('user_agent', ''), 'PHP Yar RPC-');
            if ($isYarRpc === false && intval($this->app->request->get('not_init_session', 0)) < 1) {
                // 注册会话初始化中间键
                $this->app->middleware->add(SessionInit::class);
                // 注册语言包处理中间键
                $this->app->middleware->add(LoadLangPack::class);
            }
            // 注册访问处理中间键
            $this->app->middleware->add(function (Request $request, Closure $next) {
                $header = [];
                if (($origin = $request->header('origin', '*')) !== '*') {
                    $header['Access-Control-Allow-Origin'] = $origin;
                    $header['Access-Control-Allow-Methods'] = 'GET,PUT,POST,PATCH,DELETE';
                    $header['Access-Control-Allow-Headers'] = 'Authorization,Content-Type,If-Match,If-Modified-Since,If-None-Match,If-Unmodified-Since,X-Requested-With,Api-Name,Api-Type,Api-Token,User-Form-Token,User-Token,Token';
                    $header['Access-Control-Expose-Headers'] = 'Api-Name,Api-Type,Api-Token,User-Form-Token,User-Token,Token';
                    $header['Access-Control-Allow-Credentials'] = 'true';
                }
                // 访问模式及访问权限检查
                if ($request->isOptions()) {
                    return response()->code(204)->header($header);
                } elseif (AdminService::instance()->check()) {
                    return $next($request)->header($header);
                } elseif (AdminService::instance()->isLogin()) {
                    return json(['code' => 0, 'info' => lang('think_library_not_auth')])->header($header);
                } else {
                    return json(['code' => 0, 'info' => lang('think_library_not_login'), 'url' => sysuri('admin/login/index')])->header($header);
                }
            }, 'route');
        }
        // 动态加载应用初始化系统函数
        [$ds, $base] = [DIRECTORY_SEPARATOR, $this->app->getBasePath()];
        foreach (glob("{$base}*{$ds}sys.php") as $file) includeFile($file);
    }
}