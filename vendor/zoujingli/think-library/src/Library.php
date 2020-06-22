<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin;

use think\admin\service\AdminService;
use think\admin\service\SystemService;
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
     * 启动服务
     */
    public function boot()
    {
        // 动态绑定运行配置
        SystemService::instance()->bindRuntime();
        // 注册系统任务指令
        $this->commands([
            'think\admin\command\Queue',
            'think\admin\command\Install',
            'think\admin\command\Version',
            'think\admin\command\Database',
        ]);
    }

    /**
     * 初始化服务
     */
    public function register()
    {
        // 加载中文语言
        $this->app->lang->load(__DIR__ . '/lang/zh-cn.php', 'zh-cn');
        $this->app->lang->load(__DIR__ . '/lang/en-us.php', 'en-us');
        // 输入变量默认过滤
        $this->app->request->filter(['trim']);
        // 判断访问模式，兼容 CLI 访问控制器
        if ($this->app->request->isCli()) {
            if (empty($_SERVER['REQUEST_URI']) && isset($_SERVER['argv'][1])) {
                $this->app->request->setPathinfo($_SERVER['argv'][1]);
            }
        } else {
            // 注册会话初始化中间键
            if ($this->app->request->request('not_init_session', 0) == 0) {
                $this->app->middleware->add(SessionInit::class);
            }
            // 注册访问处理中间键
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
                } elseif (AdminService::instance()->check()) {
                    return $next($request)->header($header);
                } elseif (AdminService::instance()->isLogin()) {
                    return json(['code' => 0, 'msg' => lang('think_library_not_auth')])->header($header);
                } else {
                    return json(['code' => 0, 'msg' => lang('think_library_not_login'), 'url' => sysuri('admin/login/index')])->header($header);
                }
            }, 'route');
        }
        // 动态加入应用函数
        $sysRule = "{$this->app->getBasePath()}*/sys.php";
        foreach (glob($sysRule) as $file) includeFile($file);
    }
}