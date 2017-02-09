<?php

namespace library;

/**
 * 通用工具化辅助类
 *
 * @version 1.0
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/10/20 16:21
 */
class Tools {

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     * @return array
     */
    static public function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub') {
        $tree = $map = array();
        foreach ($list as $item) {
            $map[$item[$id]] = $item;
        }
        foreach ($list as $item) {
            if (isset($item[$pid]) && isset($map[$item[$pid]])) {
                $map[$item[$pid]][$son][] = &$map[$item[$id]];
            } else {
                $tree[] = &$map[$item[$id]];
            }
        }
        unset($map);
        return $tree;
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id ID Key
     * @param string $pid 父ID Key
     * @param string $path
     * @return array
     */
    static public function arr2table($list, $id = 'id', $pid = 'pid', $path = 'path', $ppath = '') {
        $_array_tree = self::arr2tree($list);
        $tree = array();
        foreach ($_array_tree as $_tree) {
            $_tree[$path] = $ppath . '-' . $_tree['id'];
            $_tree['spl'] = str_repeat("&nbsp;&nbsp;&nbsp;├ ", substr_count($ppath, '-'));
            if (!isset($_tree['sub'])) {
                $_tree['sub'] = array();
            }
            $sub = $_tree['sub'];
            unset($_tree['sub']);
            $tree[] = $_tree;
            if (!empty($sub)) {
                $sub_array = self::arr2table($sub, $id, $pid, $path, $_tree[$path]);
                $tree = array_merge($tree, (Array) $sub_array);
            }
        }
        return $tree;
    }

    /**
     * 获取数据树子ID
     * @param array $list 数据列表
     * @param int $id 起始ID
     * @param string $key 子Key
     * @param string $pkey 父Key
     * @return array
     */
    static public function getArrSubIds($list, $id = 0, $key = 'id', $pkey = 'pid') {
        $ids = array(intval($id));
        foreach ($list as $vo) {
            if (intval($vo[$pkey]) > 0 && intval($vo[$pkey]) == intval($id)) {
                $ids = array_merge($ids, self::getArrSubIds($list, intval($vo[$key]), $key, $pkey));
            }
        }
        return $ids;
    }

    /**
     * 一维数据数组生成数据树(节点)
     * @param array $_array_tree 数据列表
     * @param string $node 节点
     * @param string $pnode 父节点
     * @param string $path
     * @param string $ppath
     * @return array
     */
    static public function node2table($_array_tree, $node = 'node', $pnode = 'pnode', $path = "id", $ppath = '') {
        $tree = array();
        foreach ($_array_tree as $_tree) {
            $_tree[$path . "_node"] = $ppath . '-' . $_tree['id'];
            $_tree['spl'] = str_repeat("&nbsp;&nbsp;&nbsp;├ ", substr_count($ppath, '-'));
            if (!isset($_tree['sub'])) {
                $_tree['sub'] = array();
            }
            $sub = $_tree['sub'];
            unset($_tree['sub']);
            $tree[] = $_tree;
            if (!empty($sub)) {
                $sub_array = self::node2table($sub, $node, $pnode, $path, $_tree[$path . "_node"]);
                $tree = array_merge($tree, (Array) $sub_array);
            }
        }
        return $tree;
    }

    /**
     * 数组解析重组
     * @param array $data 数据列表
     * @param array $params ["分组名"=>["新字段名"=>["原字段名","分割符"]]]
     * @param bool $remove 移除原字段
     * @return array
     */
    static public function parseArrayValue(array $data, $params = [], $remove = true) {
        foreach ($params as $new => $param) {
            foreach ($data as $key => $value) {
                foreach ($param as $newfield => $attr) {
                    if (is_string($attr)) {
                        $attr = [$attr, ','];
                    }
                    if ($attr[0] === $key) {
                        if (is_string($value)) {
                            foreach (explode($attr[1], $value) as $k => $v) {
                                $data[$new][$k][$newfield] = $v;
                            }
                        }
                        if ($remove) {
                            unset($data[$key]);
                        }
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 多维数组去重
     * @param array $data
     * @return array
     */
    static public function uniqueArray(array $data) {
        foreach ($data as &$v) {
            $v = json_encode($v);
        }
        $data = array_unique($data);
        foreach ($data as &$v) {
            $v = json_decode($v, true);
        }
        return $data;
    }

}
