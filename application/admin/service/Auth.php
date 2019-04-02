<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\service;

use library\tools\Data;
use library\tools\Node;
use think\Db;

/**
 * 权限访问及菜单管理
 * Class Auth
 * @package app\admin\service
 */
class Auth
{

    /**
     * 权限检查中间件入口
     * @param \think\Request $request
     * @param \Closure $next
     * @return mixed|\think\response\Json|\think\response\Redirect
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function handle(\think\Request $request, \Closure $next)
    {
        // 系统消息处理
        if (($code = $request->get('messagecode')) > 0) Message::set($code);
        // 节点忽略跳过
        $node = Node::current();
        foreach (self::getIgnore() as $str) if (stripos($node, $str) === 0) return $next($request);
        // 节点权限查询
        $auth = Db::name('SystemNode')->cache(true, 60)->field('is_auth,is_login')->where(['node' => $node])->find();
        $info = ['is_auth' => $auth['is_auth'], 'is_login' => $auth['is_auth'] ? 1 : $auth['is_login']];
        // 登录状态检查
        if (!empty($info['is_login']) && !self::isLogin()) {
            $message = ['code' => 0, 'msg' => '抱歉，您还没有登录获取访问权限！', 'url' => url('@admin/login')];
            return $request->isAjax() ? json($message) : redirect($message['url']);
        }
        // 访问权限检查
        if (!empty($info['is_auth']) && !self::checkAuthNode($node)) {
            return json(['code' => 0, 'msg' => '抱歉，您没有访问该模块的权限！']);
        }
        return $next($request);
    }

    /**
     * 权限节点忽略规则
     * @return array
     */
    public static function getIgnore()
    {
        return ['index', 'admin/login', 'admin/index'];
    }

    /**
     * 获取系统代码节点
     * @param array $nodes
     * @return array
     */
    public static function get($nodes = [])
    {
        $ignore = self::getIgnore();
        $alias = Db::name('SystemNode')->column('node,is_menu,is_auth,is_login,title');
        foreach (Node::getTree(env('app_path')) as $thr) {
            foreach ($ignore as $str) if (stripos($thr, $str) === 0) continue 2;
            $tmp = explode('/', $thr);
            list($one, $two) = ["{$tmp[0]}", "{$tmp[0]}/{$tmp[1]}"];
            $nodes[$one] = array_merge(isset($alias[$one]) ? $alias[$one] : ['node' => $one, 'title' => '', 'is_menu' => 0, 'is_auth' => 0, 'is_login' => 0], ['pnode' => '']);
            $nodes[$two] = array_merge(isset($alias[$two]) ? $alias[$two] : ['node' => $two, 'title' => '', 'is_menu' => 0, 'is_auth' => 0, 'is_login' => 0], ['pnode' => $one]);
            $nodes[$thr] = array_merge(isset($alias[$thr]) ? $alias[$thr] : ['node' => $thr, 'title' => '', 'is_menu' => 0, 'is_auth' => 0, 'is_login' => 0], ['pnode' => $two]);
        }
        foreach ($nodes as &$node) list($node['is_auth'], $node['is_menu'], $node['is_login']) = [intval($node['is_auth']), intval($node['is_menu']), empty($node['is_auth']) ? intval($node['is_login']) : 1];
        return $nodes;
    }

    /**
     * 检查用户节点权限
     * @param string $node 节点
     * @return boolean
     */
    public static function checkAuthNode($node)
    {
        list($module, $controller, $action) = explode('/', str_replace(['?', '=', '&'], '/', "{$node}///"));
        $current = Node::parseString("{$module}/{$controller}") . strtolower("/{$action}");
        // 后台入口无需要验证权限
        if (stripos($node, 'admin/index') === 0) return true;
        // 超级管理员无需要验证权限
        if (session('user.username') === 'admin') return true;
        // 未配置权限的节点默认放行
        if (!in_array($current, self::getAuthNode())) return true;
        // 用户指定角色授权放行
        return in_array($current, (array)session('user.nodes'));
    }

    /**
     * 获取授权节点
     * @return array
     */
    public static function getAuthNode()
    {
        $nodes = cache('need_access_node');
        if (empty($nodes)) {
            $nodes = Db::name('SystemNode')->where(['is_auth' => '1'])->column('node');
            cache('need_access_node', $nodes);
        }
        return $nodes;
    }

    /**
     * 应用用户权限节点
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function applyNode()
    {
        cache('need_access_node', null);
        if (($uid = session('user.id'))) session('user', Db::name('SystemUser')->where('id', $uid)->find());
        if (session('user.authorize') && ($ids = explode(',', session('user.authorize')))) {
            $auths = Db::name('SystemAuth')->whereIn('id', $ids)->where('status', '1')->column('id');
            if (empty($auths)) return session('user.nodes', []);
            return session('user.nodes', Db::name('SystemAuthNode')->whereIn('auth', $auths)->column('node'));
        }
        return false;
    }

    /**
     * 判断用户登录状态
     * @return boolean
     */
    public static function isLogin()
    {
        return !!session('user');
    }

    /**
     * 获取授权后的菜单
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAuthMenu()
    {
        self::applyNode();
        $list = Db::name('SystemMenu')->where('status', '1')->order('sort asc,id asc')->select();
        return self::buildMenuData(Data::arr2tree($list), self::get(), self::isLogin());
    }

    /**
     * 后台主菜单权限过滤
     * @param array $menus 当前菜单列表
     * @param array $nodes 系统权限节点数据
     * @param bool $isLogin 是否已经登录
     * @return array
     */
    private static function buildMenuData($menus, $nodes, $isLogin)
    {
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['sub'])) $menu['sub'] = self::buildMenuData($menu['sub'], $nodes, $isLogin);
            if (!empty($menu['sub'])) $menu['url'] = '#';
            elseif (preg_match('/^https?\:/i', $menu['url'])) continue;
            elseif ($menu['url'] !== '#') {
                $node = join('/', array_slice(explode('/', preg_replace('/[\W]/', '/', $menu['url'])), 0, 3));
                $menu['url'] = url($menu['url']) . (empty($menu['params']) ? '' : "?{$menu['params']}");
                if (isset($nodes[$node]) && $nodes[$node]['is_login'] && empty($isLogin)) unset($menus[$key]);
                elseif (isset($nodes[$node]) && $nodes[$node]['is_auth'] && $isLogin && !self::checkAuthNode($node)) unset($menus[$key]);
            } else unset($menus[$key]);
        }
        return $menus;
    }

    /**
     * 检查密码是否合法
     * @param string $password
     * @return array
     */
    public static function checkPassword($password)
    {
        $password = trim($password);
        if (!strlen($password) >= 6) {
            return ['code' => 0, 'msg' => '密码必须大于6字符！'];
        }
        if (!preg_match("/^(?![\d]+$)(?![a-zA-Z]+$)(?![^\da-zA-Z]+$).{6,32}$/", $password)) {
            return ['code' => 0, 'msg' => '密码必需包含大小写字母、数字、符号任意两者组合！'];
        }
        return ['code' => 1, 'msg' => '密码复杂度通过验证！'];
    }

}
