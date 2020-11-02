<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 以下代码来自 topthink/think-multi-app，有部分修改以兼容 ThinkAdmin 的需求
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\multiple;

use Closure;
use think\App;
use think\exception\HttpException;
use think\Request;
use think\Response;

/**
 * 多应用支持组件
 * Class Multiple
 * @package think\admin\multiple
 */
class Multiple
{
    /**
     * 应用实例
     * @var App
     */
    protected $app;

    /**
     * 应用名称
     * @var string
     */
    protected $name;

    /**
     * 应用路径
     * @var string
     */
    protected $path;

    /**
     * App constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->name = $this->app->http->getName();
        $this->path = $this->app->http->getPath();
    }

    /**
     * 多应用解析
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->parseMultiApp()) return $next($request);
        return $this->app->middleware->pipeline('app')->send($request)->then(function ($request) use ($next) {
            return $next($request);
        });
    }

    /**
     * 解析多应用
     * @return bool
     */
    protected function parseMultiApp(): bool
    {
        $defaultApp = $this->app->config->get('app.default_app') ?: 'index';
        [$script, $path] = [$this->scriptName(), $this->app->request->pathinfo()];
        if ($this->name || ($script && !in_array($script, ['index', 'router', 'think']))) {
            $appName = $this->name ?: $script;
            $this->app->http->setBind(true);
            $this->app->request->setPathinfo(preg_replace("#^{$script}\.php(/|\.|$)#i", '', $path) ?: '/');
        } else {
            $appName = null;
            $this->app->http->setBind(false);
            $bind = $this->app->config->get('app.domain_bind', []);
            if (!empty($bind)) {
                $domain = $this->app->request->host(true);
                $subDomain = $this->app->request->subDomain();
                if (isset($bind[$domain])) {
                    $appName = $bind[$domain];
                    $this->app->http->setBind(true);
                } elseif (isset($bind[$subDomain])) {
                    $appName = $bind[$subDomain];
                    $this->app->http->setBind(true);
                } elseif (isset($bind['*'])) {
                    $appName = $bind['*'];
                    $this->app->http->setBind(true);
                }
            }
            if (!$this->app->http->isBind()) {
                $map = $this->app->config->get('app.app_map', []);
                $deny = $this->app->config->get('app.deny_app_list', []);
                $name = current(explode('/', $path));
                if (strpos($name, '.')) {
                    $name = strstr($name, '.', true);
                }
                if (isset($map[$name])) {
                    if ($map[$name] instanceof Closure) {
                        $appName = call_user_func_array($map[$name], [$this->app]) ?: $name;
                    } else {
                        $appName = $map[$name];
                    }
                } elseif ($name && (false !== array_search($name, $map) || in_array($name, $deny))) {
                    throw new HttpException(404, 'app not exists:' . $name);
                } elseif ($name && isset($map['*'])) {
                    $appName = $map['*'];
                } else {
                    $appName = $name ?: $defaultApp;
                    if (stripos($appName, 'addons-') !== 0) {
                        if (!is_dir($this->path ?: $this->app->getBasePath() . $appName)) {
                            if ($this->app->config->get('app.app_express', false)) {
                                $this->setApp($defaultApp);
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
                if ($name) {
                    $this->app->request->setRoot('/' . $name);
                    $this->app->request->setPathinfo(strpos($path, '/') ? ltrim(strstr($path, '/'), '/') : '');
                }
            }
        }
        $this->setApp($appName ?: $defaultApp);
        return true;
    }

    /**
     * 设置应用参数
     * @param string $appName 应用名称
     */
    private function setApp(string $appName): void
    {
        $space = $this->app->config->get('app.app_namespace') ?: 'app';
        if (stripos($appName, 'addons-') === 0) {
            $appName = substr($appName, strlen('addons-'));
            $this->app->setNamespace("{$space}\\addons\\{$appName}");
            $appPath = $this->path ?: $this->app->getBasePath() . 'addons' . DIRECTORY_SEPARATOR . $appName . DIRECTORY_SEPARATOR;
        } else {
            $this->app->setNamespace("{$space}\\{$appName}");
            $appPath = $this->path ?: $this->app->getBasePath() . $appName . DIRECTORY_SEPARATOR;
        }
        $this->app->setAppPath($appPath);
        $this->app->http->name($appName);
        if (is_dir($appPath)) {
            $this->app->setRuntimePath($this->app->getRuntimePath() . $appName . DIRECTORY_SEPARATOR);
            $this->app->http->setRoutePath($this->app->getAppPath() . 'route' . DIRECTORY_SEPARATOR);
            $this->loadApp($appPath);
        }
    }

    /**
     * 加载应用文件
     * @param string $appPath 应用路径
     * @return void
     */
    private function loadApp(string $appPath): void
    {
        if (is_file($appPath . 'common.php')) {
            include_once $appPath . 'common.php';
        }
        $files = glob($appPath . 'config' . DIRECTORY_SEPARATOR . '*' . $this->app->getConfigExt());
        foreach ($files as $file) {
            $this->app->config->load($file, pathinfo($file, PATHINFO_FILENAME));
        }
        if (is_file($appPath . 'event.php')) {
            $this->app->loadEvent(include $appPath . 'event.php');
        }
        if (is_file($appPath . 'middleware.php')) {
            $this->app->middleware->import(include $appPath . 'middleware.php', 'app');
        }
        if (is_file($appPath . 'provider.php')) {
            $this->app->bind(include $appPath . 'provider.php');
        }
        $this->app->loadLangPack($this->app->lang->defaultLangSet());
    }

    /**
     * 获取当前运行入口名称
     * @codeCoverageIgnore
     * @return string
     */
    private function scriptName(): string
    {
        if (isset($_SERVER['SCRIPT_FILENAME'])) {
            $file = $_SERVER['SCRIPT_FILENAME'];
        } elseif (isset($_SERVER['argv'][0])) {
            $file = realpath($_SERVER['argv'][0]);
        }
        return isset($file) ? pathinfo($file, PATHINFO_FILENAME) : '';
    }
}