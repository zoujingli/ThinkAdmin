<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace library\service;

use library\Service;

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
            $dots[] = trim(preg_replace("/[A-Z]/", "_\\0", $dot), "_");
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
        $prefix = $this->request->module();
        $middle = '\\' . $this->nameTolower($this->app->request->controller());
        $suffix = ($type === 'controller') ? '' : ('\\' . $this->app->request->action());
        return strtolower(strtr($prefix . $middle . $suffix, '\\', '/'));
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
            return strtolower($this->getCurrent('controller') . "/{$node}");
        } else {
            $attrs[1] = $this->nameTolower($attrs[1]);
            return strtolower(join('/', $attrs));
        }
    }

    /**
     * 控制器方法扫描处理
     * @param boolean $force
     * @return array
     * @throws \ReflectionException
     */
    public function getMethods($force = false)
    {
        static $data = [];
        if (empty($force)) {
            if (count($data) > 0) return $data;
            $data = $this->app->cache->get('system_auth_node');
            if (is_array($data) && count($data) > 0) return $data;
        } else {
            $data = [];
        }
        $ignore = get_class_methods('\library\Controller');
        foreach ($this->scanDirectory($this->app->getAppPath()) as $file) {
            if (preg_match("|/(\w+)/controller/(.+)\.php$|i", $file, $matches)) {
                list(, $application, $baseclass) = $matches;
                $namespace = $this->app->env->get('APP_NAMESPACE');
                $class = new \ReflectionClass(strtr("{$namespace}/{$application}/controller/{$baseclass}", '/', '\\'));
                $prefix = strtr("{$application}/" . $this->nameTolower($baseclass), '\\', '/');
                $data[$prefix] = $this->parseComment($class->getDocComment(), $baseclass);
                foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    if (in_array($method->getName(), $ignore)) continue;
                    $data["{$prefix}/{$method->getName()}"] = $this->parseComment($method->getDocComment(), $method->getName());
                }
            }
        }
        $this->app->cache->set('system_auth_node', $data);
        return $data;
    }

    /**
     * 解析硬节点属性
     * @param string $comment
     * @param string $default
     * @return array
     */
    private function parseComment($comment, $default = '')
    {
        $text = strtr($comment, "\n", ' ');
        $title = preg_replace('/^\/\*\s*\*\s*\*\s*(.*?)\s*\*.*?$/', '$1', $text);
        return [
            'title'   => $title ? $title : $default,
            'isauth'  => intval(preg_match('/@auth\s*true/i', $text)),
            'ismenu'  => intval(preg_match('/@menu\s*true/i', $text)),
            'islogin' => intval(preg_match('/@login\s*true/i', $text)),
        ];
    }

    /**
     * 获取所有PHP文件列表
     * @param string $path 扫描目录
     * @param array $data 额外数据
     * @param string $ext 有文件后缀
     * @return array
     */
    private function scanDirectory($path, $data = [], $ext = 'php')
    {
        foreach (glob("{$path}*") as $item) {
            if (is_dir($item)) {
                $data = array_merge($data, $this->scanDirectory("{$item}/"));
            } elseif (is_file($item) && pathinfo($item, PATHINFO_EXTENSION) === $ext) {
                $data[] = strtr($item, '\\', '/');
            }
        }
        return $data;
    }
}