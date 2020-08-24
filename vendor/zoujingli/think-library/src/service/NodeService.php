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

namespace think\admin\service;

use think\admin\Service;

/**
 * 应用节点服务管理
 * Class NodeService
 * @package think\admin\service
 */
class NodeService extends Service
{
    /**
     * 驼峰转下划线规则
     * @param string $name
     * @return string
     */
    public function nameTolower($name)
    {
        $dots = [];
        foreach (explode('.', strtr($name, '/', '.')) as $dot) {
            $dots[] = trim(preg_replace("/[A-Z]/", "_\\0", $dot), '_');
        }
        return strtolower(join('.', $dots));
    }

    /**
     * 获取当前节点内容
     * @param string $type
     * @return string
     */
    public function getCurrent($type = '')
    {
        $prefix = $this->app->getNamespace();
        $middle = '\\' . $this->nameTolower($this->app->request->controller());
        $suffix = ($type === 'controller') ? '' : ('\\' . $this->app->request->action());
        return strtr(substr($prefix, stripos($prefix, '\\') + 1) . $middle . $suffix, '\\', '/');
    }

    /**
     * 检查并完整节点内容
     * @param string $node
     * @return string
     */
    public function fullnode($node)
    {
        if (empty($node)) return $this->getCurrent();
        if (count($attrs = explode('/', $node)) === 1) {
            return $this->getCurrent('controller') . '/' . $node;
        } else {
            $attrs[1] = $this->nameTolower($attrs[1]);
            return join('/', $attrs);
        }
    }

    /**
     * 获取应用列表
     * @param array $data
     * @return array
     */
    public function getModules($data = [])
    {
        $path = $this->app->getBasePath();
        foreach (scandir($path) as $item) if ($item[0] !== '.') {
            if (is_dir(realpath($path . $item))) $data[] = $item;
        }
        return $data;
    }

    /**
     * 获取所有控制器入口
     * @param boolean $force
     * @return array
     * @throws \ReflectionException
     */
    public function getMethods($force = false)
    {
        static $data = [];
        if (empty($force)) {
            if (count($data) > 0) return $data;
            $data = $this->app->cache->get('SystemAuthNode', []);
            if (count($data) > 0) return $data;
        } else {
            $data = [];
        }
        $ignores = get_class_methods('\think\admin\Controller');
        foreach ($this->scanDirectory($this->app->getBasePath()) as $file) {
            if (preg_match("|/(\w+)/(\w+)/controller/(.+)\.php$|i", $file, $matches)) {
                [, $namespace, $appname, $classname] = $matches;
                $prefix = strtr("{$appname}/{$this->nameTolower($classname)}", '\\', '/');
                $reflection = new \ReflectionClass(strtr("{$namespace}/{$appname}/controller/{$classname}", '/', '\\'));
                $data[$prefix] = $this->_parseComment($reflection->getDocComment(), $classname);
                foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    if (in_array($metname = $method->getName(), $ignores)) continue;
                    $data["{$prefix}/{$metname}"] = $this->_parseComment($method->getDocComment(), $metname);
                }
            }
        }
        $data = array_change_key_case($data, CASE_LOWER);
        $this->app->cache->set('SystemAuthNode', $data);
        return $data;
    }

    /**
     * 解析硬节点属性
     * @param string $comment 备注内容
     * @param string $default 默认标题
     * @return array
     */
    private function _parseComment($comment, $default = '')
    {
        $text = strtr($comment, "\n", ' ');
        $title = preg_replace('/^\/\*\s*\*\s*\*\s*(.*?)\s*\*.*?$/', '$1', $text);
        if (in_array(substr($title, 0, 5), ['@auth', '@menu', '@logi'])) $title = $default;
        return [
            'title'   => $title ?: $default,
            'isauth'  => intval(preg_match('/@auth\s*true/i', $text)),
            'ismenu'  => intval(preg_match('/@menu\s*true/i', $text)),
            'islogin' => intval(preg_match('/@login\s*true/i', $text)),
        ];
    }

    /**
     * 获取所有PHP文件列表
     * @param string $path 扫描目录
     * @param array $data 额外数据
     * @param string $ext 文件后缀
     * @return array
     */
    public function scanDirectory($path, $data = [], $ext = 'php')
    {
        if (file_exists($path) && is_dir($path)) {
            foreach (scandir($path) as $item) if ($item[0] !== '.') {
                $realpath = rtrim($path, '\\/') . DIRECTORY_SEPARATOR . $item;
                if (is_readable($realpath)) if (is_dir($realpath)) {
                    $data = $this->scanDirectory($realpath, $data, $ext);
                } elseif (is_file($realpath) && (is_null($ext) || pathinfo($realpath, 4) === $ext)) {
                    $data[] = strtr($realpath, '\\', '/');
                }
            }
        }
        return $data;
    }
}