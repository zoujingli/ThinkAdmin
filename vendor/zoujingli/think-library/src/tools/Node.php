<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
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
     * 控制器忽略函数
     * @var array
     */
    protected static $ignore = ['initialize', 'success', 'error', 'redirect', 'fetch', 'assign', 'callback'];

    /**
     * 获取标准访问节点
     * @param string $node
     * @return string
     */
    public static function get($node = null)
    {
        if (empty($node)) return self::current();
        if (count(explode('/', $node)) === 1) {
            $preNode = Request::module() . '/' . Request::controller();
            return self::parseString($preNode) . '/' . strtolower($node);
        }
        if (count($attr = explode('/', $node)) >= 3) {
            $attr[1] = self::parseString($attr[1]);
        }
        return strtolower(join('/', $attr));
    }

    /**
     * 获取当前访问节点
     * @return string
     */
    public static function current()
    {
        $preNode = Request::module() . '/' . Request::controller();
        return self::parseString($preNode) . '/' . strtolower(Request::action());
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
        foreach (self::scanDir($dir) as $file) {
            list($matches, $filename) = [[], str_replace(DIRECTORY_SEPARATOR, '/', $file)];
            if (!preg_match('|/(\w+)/controller/(.+)|', $filename, $matches)) continue;
            if (class_exists($classname = env('app_namespace') . str_replace('/', '\\', substr($matches[0], 0, -4)))) {
                foreach ((new \ReflectionClass($classname))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    list($function, $comment) = [$method->getName(), $method->getDocComment()];
                    if (stripos($function, '_') === 0 || in_array($function, self::$ignore)) continue;
                    $controller = str_replace('/', '.', substr($matches[2], 0, -4));
                    if (stripos($controller, 'api.') !== false || stripos($controller, 'wap.') !== false) continue;
                    $node = self::parseString("{$matches[1]}/{$controller}") . '/' . strtolower($function);
                    $nodes[$node] = preg_replace('/^\/\*\*\*(.*?)\*.*?$/', '$1', preg_replace("/\s/", '', $comment));
                    if (stripos($nodes[$node], '@') !== false) $nodes[$node] = '';
                }
            }
        }
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
        foreach (self::scanDir($dir) as $file) {
            list($matches, $filename) = [[], str_replace(DIRECTORY_SEPARATOR, '/', $file)];
            if (!preg_match('|/(\w+)/controller/(.+)|', $filename, $matches)) continue;
            if (class_exists($classname = env('app_namespace') . str_replace('/', '\\', substr($matches[0], 0, -4)))) {
                $controller = str_replace('/', '.', substr($matches[2], 0, -4));
                if (stripos($controller, 'api.') !== false || stripos($controller, 'wap.') !== false) continue;
                $node = self::parseString("{$matches[1]}/{$controller}");
                $comment = (new \ReflectionClass($classname))->getDocComment();
                $nodes[$node] = preg_replace('/^\/\*\*\*(.*?)\*.*?$/', '$1', preg_replace("/\s/", '', $comment));
                if (stripos($nodes[$node], '@') !== false) $nodes[$node] = '';
            }
        }
        return $nodes;
    }

    /**
     * 获取节点列表
     * @param string $dir 控制器根路径
     * @param array $nodes 额外数据
     * @return array
     */
    public static function getTree($dir, $nodes = [])
    {
        foreach (self::scanDir($dir) as $file) {
            list($matches, $filename) = [[], str_replace(DIRECTORY_SEPARATOR, '/', $file)];
            if (!preg_match('|/(\w+)/controller/(.+)|', $filename, $matches)) continue;
            $classname = env('app_namespace') . str_replace('/', '\\', substr($matches[0], 0, -4));
            if (class_exists($classname)) foreach (get_class_methods($classname) as $function) {
                if (stripos($function, '_') === 0 || in_array($function, self::$ignore)) continue;
                $controller = str_replace('/', '.', substr($matches[2], 0, -4));
                if (stripos($controller, 'api.') !== false || stripos($controller, 'wap.') !== false) continue;
                $nodes[] = self::parseString("{$matches[1]}/{$controller}") . '/' . strtolower($function);
            }
        }
        return $nodes;
    }

    /**
     * 驼峰转下划线规则
     * @param string $node 节点名称
     * @return string
     */
    public static function parseString($node)
    {
        $nodes = [];
        foreach (explode('/', $node) as $str) {
            $dots = [];
            foreach (explode('.', $str) as $dot) array_push($dots, strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $dot), "_")));
            $nodes[] = join('.', $dots);
        }
        return trim(join('/', $nodes), '/');
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