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
use think\admin\extend\DataExtend;
use think\admin\extend\NodeExtend;

/**
 * 系统授权服务
 * Class MenuService
 * @package app\admin\service
 */
class AuthService
{
    /**
     * 判断是否已经登录
     * @return boolean
     */
    public static function isLogin()
    {
        return app()->session->get('user.id') ? true : false;
    }

    /**
     * 检查指定节点授权
     * --- 需要读取缓存或扫描所有节点
     * @param string $node
     * @return boolean
     * @throws \ReflectionException
     */
    public static function check($node = '')
    {
        if (app()->session->get('user.username') === 'admin') return true;
        list($real, $nodes) = [NodeExtend::fullnode($node), NodeExtend::getMethods()];
        if (!empty($nodes[$real]['isauth'])) {
            return in_array($real, app()->session->get('user.nodes', []));
        }
        return !(!empty($nodes[$real]['islogin']) && !self::isLogin());
    }

    /**
     * 获取授权节点列表
     * @param array $checkeds
     * @return array
     * @throws \ReflectionException
     */
    public static function getTree($checkeds = [])
    {
        list($nodes, $pnodes, $methods) = [[], [], array_reverse(NodeExtend::getMethods())];
        foreach ($methods as $node => $method) {
            $count = substr_count($node, '/');
            $pnode = substr($node, 0, strripos($node, '/'));
            if ($count === 2 && !empty($method['isauth'])) {
                in_array($pnode, $pnodes) or array_push($pnodes, $pnode);
                $nodes[$node] = ['node' => $node, 'title' => $method['title'], 'pnode' => $pnode, 'checked' => in_array($node, $checkeds)];
            } elseif ($count === 1 && in_array($pnode, $pnodes)) {
                $nodes[$node] = ['node' => $node, 'title' => $method['title'], 'pnode' => $pnode, 'checked' => in_array($node, $checkeds)];
            }
        }
        foreach (array_keys($nodes) as $key) foreach ($methods as $node => $method) if (stripos($key, "{$node}/") !== false) {
            $pnode = substr($node, 0, strripos($node, '/'));
            $nodes[$node] = ['node' => $node, 'title' => $method['title'], 'pnode' => $pnode, 'checked' => in_array($node, $checkeds)];
            $nodes[$pnode] = ['node' => $pnode, 'title' => ucfirst($pnode), 'pnode' => '', 'checked' => in_array($pnode, $checkeds)];
        }
        return DataExtend::arr2tree(array_reverse($nodes), 'node', 'pnode', '_sub_');
    }

    /**
     * 初始化用户权限
     * @param boolean $force 是否重置系统权限
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function apply($force = false)
    {
        $app = app();
        if ($force) $app->cache->delete('system_auth_node');
        if (($uid = $app->session->get('user.id'))) {
            $user = $app->db->name('SystemUser')->where(['id' => $uid])->find();
            if (($aids = $user['authorize'])) {
                $where = [['status', 'eq', '1'], ['id', 'in', explode(',', $aids)]];
                $subsql = $app->db->name('SystemAuth')->field('id')->where($where)->buildSql();
                $user['nodes'] = array_unique($app->db->name('SystemAuthNode')->whereRaw("auth in {$subsql}")->column('node'));
                $app->session->set('user', $user);
            } else {
                $user['nodes'] = [];
                $app->session->set('user', $user);
            }
        }
    }

}