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

/**
 * 控制器节点管理器
 * Class Node
 * @package library\tools
 */
class Node
{
    /**
     * 获取当前访问节点
     * @return string
     */
    public static function current()
    {
        $request = request();
        list($module, $controller, $action) = [$request->module(), $request->controller(), $request->action()];
        return self::parseString("{$module}/{$controller}") . '/' . strtolower($action);
    }

    /**
     * 获取节点列表
     * @param string $dir 控制器根路径
     * @param array $nodes 额外数据
     * @return array
     */
    public static function getTree($dir, $nodes = [])
    {
        $ignore = ['initialize', 'success', 'error', 'redirect', 'fetch', 'assign', 'callback'];
        foreach (self::scanDir($dir) as $file) {
            list($matches, $filename) = [[], str_replace(DIRECTORY_SEPARATOR, '/', $file)];
            if (!preg_match('|/(\w+)/controller/(.+)|', $filename, $matches)) continue;
            $className = env('app_namespace') . str_replace('/', '\\', substr($matches[0], 0, -4));
            if (class_exists($className)) foreach (get_class_methods($className) as $funcName) {
                if (stripos($funcName, '_') === 0 || in_array($funcName, $ignore)) continue;
                $controller = str_replace('/', '.', substr($matches[2], 0, -4));
                if (stripos($controller, 'api.') !== false || stripos($controller, 'wap.') !== false) continue;
                $nodes[] = self::parseString("{$matches[1]}/{$controller}") . '/' . strtolower($funcName);
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
        foreach (scandir($dir) as $_dir) if (strpos($_dir, '.') !== 0) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $_dir);
            if (is_dir($path)) $data = array_merge($data, self::scanDir($path));
            elseif (pathinfo($path, 4) === $ext) $data[] = $path;
        }
        return $data;
    }

}