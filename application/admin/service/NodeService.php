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

namespace app\admin\service;

use library\tools\Data;
use library\tools\Node;
use think\Db;
use think\facade\App;
use think\facade\Cache;
use think\facade\Request;

/**
 * 功能节点管理服务
 * Class NodeService
 * @package app\admin\service
 */
class NodeService
{

    /**
     * 获取标准访问节点
     * @param string $node
     * @return string
     */
    public static function full($node = null)
    {
        if (empty($node)) return self::current();
        if (count(explode('/', $node)) === 1) {
            $node = Request::module() . '/' . Request::controller() . '/' . $node;
        }
        return self::parseString(trim($node, " /"));
    }

    /**
     * 判断是否已经登录
     * @return boolean
     */
    public static function islogin()
    {
        return session('admin_user.id') ? true : false;
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
     * 检查密码是否合法
     * @param string $password
     * @return array
     */
    public static function checkpwd($password)
    {
        $password = trim($password);
        if (!strlen($password) >= 6) {
            return ['code' => 0, 'msg' => '密码必须大于6字符！'];
        }
        if (!preg_match("/^(?![\d]+$)(?![a-zA-Z]+$)(?![^\da-zA-Z]+$).{6,32}$/", $password)) {
            return ['code' => 0, 'msg' => '密码必需包含大小写字母、数字、符号任意两者组合！'];
        } else {
            return ['code' => 1, 'msg' => '密码复杂度通过验证！'];
        }
    }

    /**
     * 获取可选菜单节点
     * @return array
     * @throws \ReflectionException
     */
    public static function getMenuNodeList()
    {
        static $nodes = [];
        if (count($nodes) > 0) return $nodes;
        foreach (self::getMethodList() as $node => $method) if ($method['menu']) {
            $nodes[] = ['node' => $node, 'title' => $method['title']];
        }
        return $nodes;
    }

    /**
     * 获取系统菜单树数据
     * @return array
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getMenuNodeTree()
    {
        $list = Db::name('SystemMenu')->where(['status' => '1'])->order('sort desc,id asc')->select();
        return self::buildMenuData(Data::arr2tree($list), self::getMethodList());
    }

    /**
     * 后台主菜单权限过滤
     * @param array $menus 当前菜单列表
     * @param array $nodes 系统权限节点
     * @return array
     * @throws \ReflectionException
     */
    private static function buildMenuData($menus, $nodes)
    {
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['sub'])) $menu['sub'] = self::buildMenuData($menu['sub'], $nodes);
            if (!empty($menu['sub'])) $menu['url'] = '#';
            elseif (preg_match('/^https?\:/i', $menu['url'])) continue;
            elseif ($menu['url'] === '#') unset($menus[$key]);
            else {
                $node = join('/', array_slice(explode('/', preg_replace('/[\W]/', '/', $menu['url'])), 0, 3));
                $menu['url'] = url($menu['url']) . (empty($menu['params']) ? '' : "?{$menu['params']}");
                if (!self::checkAuth($node)) unset($menus[$key]);
            }
        }
        return $menus;
    }

    /**
     * 获取授权节点列表
     * @return array
     * @throws \ReflectionException
     */
    public static function getAuthList()
    {
        static $nodes = [];
        if (count($nodes) > 0) return $nodes;
        $nodes = Cache::tag('system')->get('NodeAuthList', []);
        if (count($nodes) > 0) return $nodes;
        foreach (self::getMethodList() as $key => $node) {
            if ($node['auth']) $nodes[$key] = $node['title'];
        }
        Cache::tag('system')->set('NodeAuthList', $nodes);
        return $nodes;
    }

    /**
     * 强制验证访问权限
     * --- 需要加载控制器解析注释
     * @param null|string $node
     * @return boolean
     * @throws \ReflectionException
     */
    public static function forceAuth($node = null)
    {
        if (session('admin_user.username') === 'admin') return true;
        $real = is_null($node) ? self::current() : self::full($node);
        list($module, $controller, $action) = explode('/', $real);
        if (class_exists($class = App::parseClass($module, 'controller', $controller))) {
            $reflection = new \ReflectionClass($class);
            if ($reflection->hasMethod($action)) {
                $comment = preg_replace("/\s/", '', $reflection->getMethod($action)->getDocComment());
                if (stripos($comment, '@authtrue') === false) return true;
                return in_array($real, (array)session('admin_user.nodes'));
            }
        }
        return true;
    }

    /**
     * 检查指定节点授权
     * --- 需要读取缓存或扫描所有节点
     * @param null|string $node
     * @return boolean
     * @throws \ReflectionException
     */
    public static function checkAuth($node = null)
    {
        if (session('admin_user.username') === 'admin') return true;
        $real = is_null($node) ? self::current() : self::full($node);
        if (isset(self::getAuthList()[$real])) {
            return in_array($real, (array)session('admin_user.nodes'));
        } else {
            return true;
        }
    }

    /**
     * 获取授权节点列表
     * @param array $checkeds
     * @return array
     * @throws \ReflectionException
     */
    public static function getAuthTree($checkeds = [])
    {
        static $nodes = [];
        if (count($nodes) > 0) return $nodes;
        foreach (self::getAuthList() as $node => $title) {
            $pnode = substr($node, 0, strripos($node, '/'));
            $nodes[$node] = ['node' => $node, 'title' => $title, 'pnode' => $pnode, 'checked' => in_array($node, $checkeds)];
        }
        foreach (self::getClassList() as $node => $title) foreach (array_keys($nodes) as $key) {
            if (stripos($key, "{$node}/") !== false) {
                $pnode = substr($node, 0, strripos($node, '/'));
                $nodes[$node] = ['node' => $node, 'title' => $title, 'pnode' => $pnode, 'checked' => in_array($node, $checkeds)];
                $nodes[$pnode] = ['node' => $pnode, 'title' => ucfirst($pnode), 'checked' => in_array($pnode, $checkeds)];
            }
        }
        return $nodes = Data::arr2tree($nodes, 'node', 'pnode', '_sub_');
    }

    /**
     * 初始化用户权限
     * @param boolean $force 是否重置系统权限
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function applyUserAuth($force = false)
    {
        if ($force) {
            Cache::tag('system')->rm('NodeAuthList');
            Cache::tag('system')->rm('NodeClassData');
            Cache::tag('system')->rm('NodeMethodData');
        }
        if (($uid = session('admin_user.id'))) {
            session('admin_user', Db::name('SystemUser')->where(['id' => $uid])->find());
        }
        if (($aids = session('admin_user.authorize'))) {
            $where = [['status', 'eq', '1'], ['id', 'in', explode(',', $aids)]];
            $subsql = Db::name('SystemAuth')->field('id')->where($where)->buildSql();
            session('admin_user.nodes', array_unique(Db::name('SystemAuthNode')->whereRaw("auth in {$subsql}")->column('node')));
        } else {
            session('admin_user.nodes', []);
        }
    }

    /**
     * 获取控制器节点列表
     * @return array
     * @throws \ReflectionException
     */
    public static function getClassList()
    {
        static $nodes = [];
        if (count($nodes) > 0) return $nodes;
        $nodes = Cache::tag('system')->get('NodeClassData', []);
        if (count($nodes) > 0) return $nodes;
        self::eachController(function (\ReflectionClass $reflection, $prenode) use (&$nodes) {
            list($node, $comment) = [trim($prenode, ' / '), $reflection->getDocComment()];
            $nodes[$node] = preg_replace('/^\/\*\*\*(.*?)\*.*?$/', '$1', preg_replace("/\s/", '', $comment));
            if (stripos($nodes[$node], '@') !== false) $nodes[$node] = '';
        });
        Cache::tag('system')->set('NodeClassData', $nodes);
        return $nodes;
    }

    /**
     * 获取方法节点列表
     * @return array
     * @throws \ReflectionException
     */
    public static function getMethodList()
    {
        static $nodes = [];
        if (count($nodes) > 0) return $nodes;
        $nodes = Cache::tag('system')->get('NodeMethodData', []);
        if (count($nodes) > 0) return $nodes;
        self::eachController(function (\ReflectionClass $reflection, $prenode) use (&$nodes) {
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $action = strtolower($method->getName());
                list($node, $comment) = ["{$prenode}{$action}", preg_replace("/\s/", '', $method->getDocComment())];
                $nodes[$node] = [
                    'auth'  => stripos($comment, '@authtrue') !== false,
                    'menu'  => stripos($comment, '@menutrue') !== false,
                    'title' => preg_replace('/^\/\*\*\*(.*?)\*.*?$/', '$1', $comment),
                ];
                if (stripos($nodes[$node]['title'], '@') !== false) $nodes[$node]['title'] = '';
            }
        });
        Cache::tag('system')->set('NodeMethodData', $nodes);
        return $nodes;
    }

    /**
     * 控制器扫描回调
     * @param callable $callable
     * @throws \ReflectionException
     */
    public static function eachController($callable)
    {
        foreach (self::scanPath(env('app_path') . "*/controller/") as $file) {
            if (!preg_match("|/(\w+)/controller/(.+)\.php$|", $file, $matches)) continue;
            list($module, $controller) = [$matches[1], strtr($matches[2], '/', '.')];
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
     * 获取所有PHP文件列表
     * @param string $dirname 扫描目录
     * @param array $data 额外数据
     * @param string $ext 有文件后缀
     * @return array
     */
    private static function scanPath($dirname, $data = [], $ext = 'php')
    {
        foreach (glob("{$dirname}*") as $file) {
            if (is_dir($file)) {
                $data = array_merge($data, self::scanPath("{$file}/"));
            } elseif (is_file($file) && pathinfo($file, 4) === $ext) {
                $data[] = str_replace('\\', '/', $file);
            }
        }
        return $data;
    }

}
