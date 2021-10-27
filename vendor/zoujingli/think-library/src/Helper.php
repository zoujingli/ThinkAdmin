<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin;

use think\admin\extend\VirtualModel;
use think\App;
use think\Container;
use think\db\BaseQuery;
use think\db\Mongo;
use think\db\Query;
use think\Model;

/**
 * 控制器挂件
 * Class Helper
 * @package think\admin
 */
abstract class Helper
{
    /**
     * 应用容器
     * @var App
     */
    public $app;

    /**
     * 控制器实例
     * @var Controller
     */
    public $class;

    /**
     * 当前请求方式
     * @var string
     */
    public $method;

    /**
     * 自定输出格式
     * @var string
     */
    public $output;

    /**
     * Helper constructor.
     * @param App $app
     * @param Controller $class
     */
    public function __construct(App $app, Controller $class)
    {
        $this->app = $app;
        $this->class = $class;
        // 计算指定输出格式
        $this->method = $app->request->method() ?: ($app->request->isCli() ? 'cli' : 'nil');
        $this->output = strtolower("{$this->method}.{$app->request->request('output', 'default')}");
    }

    /**
     * 实例对象反射
     * @param array $args
     * @return static
     */
    public static function instance(...$args): Helper
    {
        return Container::getInstance()->invokeClass(static::class, $args);
    }

    /**
     * 获取数据库查询对象
     * @param Model|BaseQuery|string $query
     * @return Query|Mongo|BaseQuery
     */
    public static function buildQuery($query)
    {
        if (is_string($query)) {
            return self::buildModel($query)->db();
        }
        if ($query instanceof Model) return $query->db();
        if ($query instanceof BaseQuery && !$query->getModel()) {
            $query->model(self::buildModel($query->getName()));
        }
        return $query;
    }

    /**
     * 动态创建模型对象
     * @param mixed $name 模型名称
     * @param array $data 初始数据
     * @param mixed $conn 指定连接
     * @return Model
     */
    public static function buildModel(string $name, array $data = [], string $conn = ''): Model
    {
        if (strpos($name, '\\') !== false) {
            if (class_exists($name)) {
                $model = new $name($data);
                if ($model instanceof Model) return $model;
            }
            $name = basename(str_replace('\\', '/', $name));
        }
        return VirtualModel::mk($name, $data, $conn);
    }
}