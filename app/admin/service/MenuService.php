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

use think\admin\extend\DataExtend;
use think\admin\extend\NodeExtend;

/**
 * 系统菜单服务
 * Class MenuService
 * @package app\admin\service
 */
class MenuService
{

    /**
     * 获取可选菜单节点
     * @return array
     * @throws \ReflectionException
     */
    public static function getList()
    {
        static $nodes = [];
        if (count($nodes) > 0) return $nodes;
        foreach (NodeExtend::getMethods() as $node => $method) if ($method['ismenu']) {
            $nodes[] = ['node' => $node, 'title' => $method['title']];
        }
        return $nodes;
    }

    /**
     * 获取系统菜单树数据
     * @return array
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getTree()
    {
        $result = app()->db->name('SystemMenu')->where(['status' => '1'])->order('sort desc,id asc')->select();
        return self::buildData(DataExtend::arr2tree($result->toArray()), NodeExtend::getMethods());
    }

    /**
     * 后台主菜单权限过滤
     * @param array $menus 当前菜单列表
     * @param array $nodes 系统权限节点
     * @return array
     * @throws \ReflectionException
     */
    private static function buildData($menus, $nodes)
    {
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['sub'])) {
                $menu['sub'] = self::buildData($menu['sub'], $nodes);
            }
            if (!empty($menu['sub'])) $menu['url'] = '#';
            elseif ($menu['url'] === '#') unset($menus[$key]);
            elseif (preg_match('|^https?://|i', $menu['url'])) continue;
            else {
                $node = join('/', array_slice(explode('/', preg_replace('/[\W]/', '/', $menu['url'])), 0, 3));
                $menu['url'] = url($menu['url']) . (empty($menu['params']) ? '' : "?{$menu['params']}");
                if (!AuthService::check($node)) unset($menus[$key]);
            }
        }
        return $menus;
    }
}