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

use think\App;

/**
 * 自定义服务接口
 * Class Service
 * @package think\admin
 */
abstract class Service
{
    /**
     * 应用实例
     * @var App
     */
    protected $app;

    /**
     * 实例缓存
     * @var $this
     */
    protected static $cache = [];

    /**
     * Service constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->init();
    }

    /**
     * 服务初始化
     */
    protected function init()
    {
    }

    /**
     * 静态实例对象
     * @param App $app
     * @return $this
     */
    public static function instance(App $app = null)
    {
        if (is_null($app)) $app = app();
        $key = md5(get_called_class());
        if (!isset(self::$cache[$key])) {
            self::$cache[$key] = new static($app);
        }
        return self::$cache[$key];
    }
}