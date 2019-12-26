<?php
// +-----------------------+
// | 注释不留名，代码随便用 |
// +-----------------------+


namespace app\admin\install;


use think\Request;
use think\Route;

class CheckInstall
{
    public function handle(Request $request, \Closure $next)
    {
        if (!is_file(__DIR__ . DIRECTORY_SEPARATOR . 'install.lock') && !in_array($request->url(), ['/install/index', '/install/execute'])) {
            return redirect("/install/index");
        }
        return $next($request);
    }
}