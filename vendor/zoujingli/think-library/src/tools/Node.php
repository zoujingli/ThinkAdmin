<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\tools;

use think\facade\Request;

/**
 * 控制器节点管理器
 * Class Node
 * @package library\tools
 */
class Node
{

    /**
     * 忽略控制名的前缀
     * @var array
     */
    private static $ignoreController = [
        'api.', 'wap.', 'web.',
    ];

    /**
     * 忽略控制的方法名
     * @var array
     */
    private static $ignoreAction = [
        '_', 'redirect', 'assign', 'callback',
        'initialize', 'success', 'error', 'fetch',
    ];

    /**
     * 获取标准访问节点
     * @param string $node
     * @return string
     */
    public static function get($node = null)
    {
        if (empty($node)) return self::current();
        if (count(explode('/', $node)) === 1) {
            $node = Request::module() . '/' . Request::controller() . '/' . $node;
        }
        return self::parseString(trim($node));
    }

    /**
     * 获取当前访问节点
     * @return string
     */
    public static function current()
    {
        return self::parseString(Request::module() . '/' . Request::controller() . '/' . Request::action());
    }

    /**
     * 获取节点列表
     * @param string $dir 控制器根路径
     * @param array $nodes 额外数据
     * @return array
     * @throws \ReflectionException
     */
    public static function getTree($dir, $nodes = [])
    {
        self::eachController($dir, function (\ReflectionClass $reflection, $prenode) use (&$nodes) {
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $action = strtolower($method->getName());
                foreach (self::$ignoreAction as $ignore) if (stripos($action, $ignore) === 0) continue 2;
                $nodes[] = $prenode . $action;
            };
        });
        return $nodes;
    }

    /**
     * 获取控制器节点列表
     * @param string $dir 控制器根路径
     * @param array $nodes 额外数据
     * @return array
     * @throws \ReflectionException
     */
    public static function getClassTreeNode($dir, $nodes = [])
    {
        self::eachController($dir, function (\ReflectionClass $reflection, $prenode) use (&$nodes) {
            list($node, $comment) = [trim($prenode, '/'), $reflection->getDocComment()];
            $nodes[$node] = preg_replace('/^\/\*\*\*(.*?)\*.*?$/', '$1', preg_replace("/\s/", '', $comment));
            if (stripos($nodes[$node], '@') !== false) $nodes[$node] = '';
        });
        return $nodes;
    }

    /**
     * 获取方法节点列表
     * @param string $dir 控制器根路径
     * @param array $nodes 额外数据
     * @return array
     * @throws \ReflectionException
     */
    public static function getMethodTreeNode($dir, $nodes = [])
    {
        self::eachController($dir, function (\ReflectionClass $reflection, $prenode) use (&$nodes) {
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $action = strtolower($method->getName());
                foreach (self::$ignoreAction as $ignore) if (stripos($action, $ignore) === 0) continue 2;
                $node = $prenode . $action;
                $nodes[$node] = preg_replace('/^\/\*\*\*(.*?)\*.*?$/', '$1', preg_replace("/\s/", '', $method->getDocComment()));
                if (stripos($nodes[$node], '@') !== false) $nodes[$node] = '';
            }
        });
        return $nodes;
    }

    /**
     * 控制器扫描回调
     * @param string $dir
     * @param callable $callable
     * @throws \ReflectionException
     */
    public static function eachController($dir, $callable)
    {
        foreach (Node::scanDir($dir) as $file) {
            if (!preg_match("|/(\w+)/controller/(.+)\.php$|", strtr($file, '\\', '/'), $matches)) continue;
            list($module, $controller) = [$matches[1], strtr($matches[2], '/', '.')];
            foreach (self::$ignoreController as $ignore) if (stripos($controller, $ignore) === 0) continue 2;
            if (class_exists($class = substr(strtr(env('app_namespace') . $matches[0], '/', '\\'), 0, -4))) {
                call_user_func($callable, new \ReflectionClass($class), Node::parseString("{$module}/{$controller}/"));
            }
        }
    }

    /**
     * 驼峰转下划线规则
     * @param string $node 节点名称
     * @return string
     */
    public static function parseString($node)
    {
        if (count($nodes = explode('/', $node)) > 1) {
            $dots = [];
            foreach (explode('.', $nodes[1]) as $dot) {
                $dots[] = trim(preg_replace("/[A-Z]/", "_\\0", $dot), "_");
            }
            $nodes[1] = join('.', $dots);
        }
        return strtolower(join('/', $nodes));
    }

    /**
     * 获取所有PHP文件
     * @param string $dir 目录
     * @param array $data 额外数据
     * @param string $ext 有文件后缀
     * @return array
     */
    public static function scanDir($dir, $data = [], $ext = 'php')
    {
        foreach (scandir($dir) as $curr) if (strpos($curr, '.') !== 0) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $curr);
            if (is_dir($path)) $data = array_merge($data, self::scanDir($path));
            elseif (pathinfo($path, PATHINFO_EXTENSION) === $ext) $data[] = $path;
        }
        return $data;
    }

    /**
     * 递归统计目录大小
     * @param string $path 目录
     * @return integer
     */
    public static function totalDirSize($path)
    {
        list($total, $path) = [0, realpath($path)];
        if (!file_exists($path)) return $total;
        if (!is_dir($path)) return filesize($path);
        if ($handle = opendir($path)) {
            while ($file = readdir($handle)) if (!in_array($file, ['.', '..'])) {
                $temp = $path . DIRECTORY_SEPARATOR . $file;
                $total += (is_dir($temp) ? self::totalDirSize($temp) : filesize($temp));
            }
            if (is_resource($handle)) closedir($handle);
        }
        return $total;
    }

}
