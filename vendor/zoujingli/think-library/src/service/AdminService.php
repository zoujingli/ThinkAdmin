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

namespace think\admin\service;

namespace library\service;

use library\Service;
use library\tools\Data;
use think\Db;

/**
 * 系统权限管理服务
 * Class AdminService
 * @package think\admin\service
 */
class AdminService extends Service
{

    /**
     * 判断是否已经登录
     * @return boolean
     */
    public function isLogin()
    {
        return $this->app->session->get('user.id') ? true : false;
    }

    /**
     * 检查指定节点授权
     * --- 需要读取缓存或扫描所有节点
     * @param string $node
     * @return boolean
     * @throws \ReflectionException
     */
    public function check($node = '')
    {
        $service = NodeService::instance();
        if ($this->app->session->get('user.username') === 'admin') return true;
        list($real, $nodes) = [$service->fullnode($node), $service->getMethods()];
        if (empty($nodes[$real]['isauth'])) {
            return empty($nodes[$real]['islogin']) ? true : $this->isLogin();
        } else {
            return in_array($real, (array)$this->app->session->get('user.nodes'));
        }
    }

    /**
     * 获取授权节点列表
     * @param array $checkeds
     * @return array
     * @throws \ReflectionException
     */
    public function getTree($checkeds = [])
    {
        list($nodes, $pnodes) = [[], []];
        $methods = array_reverse(NodeService::instance()->getMethods());
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
        return Data::arr2tree(array_reverse($nodes), 'node', 'pnode', '_sub_');
    }

    /**
     * 初始化用户权限
     * @param boolean $force 强刷权限
     * @return AdminService
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function apply($force = false)
    {
        if ($force) $this->app->cache->rm('system_auth_node');
        if (($uid = $this->app->session->get('user.id'))) {
            $user = Db::name('SystemUser')->where(['id' => $uid])->find();
            if (($aids = $user['authorize'])) {
                $where = [['status', 'eq', '1'], ['id', 'in', explode(',', $aids)]];
                $subsql = Db::name('SystemAuth')->field('id')->where($where)->buildSql();
                $user['nodes'] = array_unique(Db::name('SystemAuthNode')->whereRaw("auth in {$subsql}")->column('node'));
                $this->app->session->set('user', $user);
            } else {
                $user['nodes'] = [];
                $this->app->session->set('user', $user);
            }
        }
        return $this;
    }

}