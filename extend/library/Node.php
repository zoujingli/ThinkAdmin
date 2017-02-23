<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace library;

/**
 * 代码节点分析器
 * 
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/23 14:46
 */
class Node {

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
            $controllerName = rtrim(array_pop($_tmp), '.php');
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
    static public function getFilePaths($path, $data = [], $ext = 'php') {
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
