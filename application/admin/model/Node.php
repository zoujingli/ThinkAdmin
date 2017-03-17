<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Db;

/**
 * 系统用户管理控制器
 * Class Node
 * @package app\admin\model
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/14 18:12
 */
class Node {

    /**
     * 获取系统代码节点
     * @return array
     */
    static public function get() {
        $data = Db::name('SystemNode')->select();
        $nodes = [];
        $alias = [];
        foreach ($data as $vo) {
            $alias["{$vo['node']}"] = $vo;
        }
        foreach (self::getNodeTree(APP_PATH) as $thr) {
            if (stripos($thr, 'admin/plugs') === 0 || stripos($thr, 'admin/login') === 0 || stripos($thr, 'admin/index') === 0 || stripos($thr, 'index') === 0 || stripos($thr, 'store/api') === 0) {
                continue;
            }
            $tmp = explode('/', $thr);
            $one = $tmp[0];
            $two = "{$tmp[0]}/{$tmp[1]}";
            $nodes[$one] = array_merge(isset($alias[$one]) ? $alias[$one] : ['node' => $one, 'title' => '', 'is_menu' => 0, 'is_auth' => 0], ['pnode' => '']);
            $nodes[$two] = array_merge(isset($alias[$two]) ? $alias[$two] : ['node' => $two, 'title' => '', 'is_menu' => 0, 'is_auth' => 0], ['pnode' => $one]);
            $nodes[$thr] = array_merge(isset($alias[$thr]) ? $alias[$thr] : ['node' => $thr, 'title' => '', 'is_menu' => 0, 'is_auth' => 0], ['pnode' => $two]);
        }
        return $nodes;
    }

    /**
     * 获取节点列表
     * @param string $path
     * @param array $nodes
     * @return array
     */
    static public function getNodeTree($path, $nodes = []) {
        foreach (self::getFilePaths($path) as $vo) {
            if (stripos($vo, DS . 'controller' . DS) === false) {
                continue;
            }
            $_tmp = explode(DS, $vo);
            $controllerName = preg_replace('|\.php$|', '', array_pop($_tmp));
            array_pop($_tmp);
            $moduleName = array_pop($_tmp);
            $className = config('app_namespace') . "\\{$moduleName}\\controller\\{$controllerName}";
            if (!class_exists($className)) {
                continue;
            }
            foreach (get_class_methods($className) as $actionName) {
                if ($actionName[0] !== '_') {
                    $nodes[] = strtolower("{$moduleName}/{$controllerName}/{$actionName}");
                }
            }
        }
        return $nodes;
    }

    /**
     * 获取所有PHP文件
     * @param string $path
     * @param array $data
     * @param string $ext
     * @return array
     */
    static private function getFilePaths($path, $data = [], $ext = 'php') {
        foreach (scandir($path) as $dir) {
            if ($dir[0] === '.') {
                continue;
            }
            $tmp = realpath($path . DS . $dir);
            if ($tmp && (is_dir($tmp) || pathinfo($tmp, PATHINFO_EXTENSION) === $ext)) {
                is_dir($tmp) ? $data = array_merge($data, self::getFilePaths($tmp)) : $data[] = $tmp;
            }
        }
        return $data;
    }

}
