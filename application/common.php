<?php
// +-----------------------+
// | 注释不留名，代码随便用 |
// +-----------------------+
\think\facade\Middleware::add(\app\admin\install\CheckInstall::class);
\think\facade\Route::any('install/:action$', function($action){
    return app()->invokeMethod([\app\admin\install\Install::class, $action]);
});