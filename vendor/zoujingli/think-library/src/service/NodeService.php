<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

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
    public function nameTolower(string $name): string
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
    public function getCurrent(string $type = ''): string
    {
        $space = $this->app->getNamespace();
        $prefix = strtolower($this->app->http->getName());
        if (preg_match("|\\\\addons\\\\{$prefix}$|", $space)) {
            $prefix = "addons-{$prefix}";
        }
        // 获取应用前缀节点
        if ($type === 'module') return $prefix;
        // 获取控制器前缀节点
        $middle = $this->nameTolower($this->app->request->controller());
        if ($type === 'controller') return $prefix . '/' . $middle;
        // 获取完整的权限节点
        return $prefix . '/' . $middle . '/' . strtolower($this->app->request->action());
    }

    /**
     * 检查并完整节点内容
     * @param null|string $node
     * @return string
     */
    public function fullnode(?string $node = ''): string
    {
        if (empty($node)) {
            return $this->getCurrent();
        }
        switch (count($attrs = explode('/', $node))) {
            case 2:
                $suffix = $this->nameTolower($attrs[0]) . '/' . $attrs[1];
                return $this->getCurrent('module') . '/' . strtolower($suffix);
            case 1:
                return $this->getCurrent('controller') . '/' . strtolower($node);
            default:
                $attrs[1] = $this->nameTolower($attrs[1]);
                return strtolower(join('/', $attrs));
        }
    }

    /**
     * 获取应用列表
     * @param array $data
     * @return array
     */
    public function getModules(array $data = []): array
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
    public function getMethods(bool $force = false): array
    {
        static $data = [];
        if (empty($force)) {
            if (count($data) > 0) return $data;
            $data = $this->app->cache->get('SystemAuthNode', []);
            if (count($data) > 0) return $data;
        } else {
            $data = [];
        }
        /*! 排除内置方法，禁止访问内置方法 */
        $ignores = get_class_methods('\think\admin\Controller');
        /*! 扫描所有代码控制器节点，更新节点缓存 */
        foreach ($this->scanDirectory($this->app->getBasePath()) as $file) {
            $name = substr($file, strlen(strtr($this->app->getRootPath(), '\\', '/')) - 1);
            if (preg_match("|^([\w/]+)/(\w+)/controller/(.+)\.php$|i", $name, $matches)) {
                [, $namespace, $appname, $classname] = $matches;
                $addons = preg_match('|/addons$|', $namespace) ? 'addons-' : '';
                $class = new \ReflectionClass(strtr("{$namespace}/{$appname}/controller/{$classname}", '/', '\\'));
                $prefix = strtolower(strtr("{$addons}{$appname}/{$this->nameTolower($classname)}", '\\', '/'));
                $data[$prefix] = $this->_parseComment($class->getDocComment() ?: '', $classname);
                foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    if (in_array($metname = $method->getName(), $ignores)) continue;
                    $data[strtolower("{$prefix}/{$metname}")] = $this->_parseComment($method->getDocComment() ?: '', $metname);
                }
            }
        }
        $this->app->cache->set('SystemAuthNode', $data);
        return $data;
    }

    /**
     * 解析硬节点属性
     * @param string $comment 备注内容
     * @param string $default 默认标题
     * @return array
     */
    private function _parseComment(string $comment, string $default = ''): array
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
     * @param null|string $ext 文件后缀
     * @return array
     */
    public function scanDirectory(string $path, array $data = [], $ext = 'php'): array
    {
        if (file_exists($path)) {
            if (is_file($path)) {
                $data[] = strtr($path, '\\', '/');
            } elseif (is_dir($path)) foreach (scandir($path) as $item) if ($item[0] !== '.') {
                $real = rtrim($path, '\\/') . DIRECTORY_SEPARATOR . $item;
                if (is_readable($real)) if (is_dir($real)) {
                    $data = $this->scanDirectory($real, $data, $ext);
                } elseif (is_file($real) && (is_null($ext) || pathinfo($real, 4) === $ext)) {
                    $data[] = strtr($real, '\\', '/');
                }
            }
        }
        return $data;
    }
}