<?php

namespace library;

/**
 * 代码节点读取工具
 *
 * @author shaobo <luoshaobo@cuci.cc>
 * @date 2016-10-21
 */
class Node {

    /**
     * 获取所有PHP文件
     * @param string $path
     * @param array $data
     * @return array
     */
    static public function getTree($path, $data = []) {
        foreach (scandir($path) as $dir) {
            if ($dir[0] === '.') {
                continue;
            }
            $tmp = realpath($path . DIRECTORY_SEPARATOR . $dir);
            if ($tmp && (is_dir($tmp) || pathinfo($tmp, PATHINFO_EXTENSION) === 'php')) {
                is_dir($tmp) ? $data = array_merge($data, self::getTree($tmp)) : $data[] = $tmp;
            }
        }
        return $data;
    }

    /**
     * 处理类继承关系
     * @param array $data
     * @param string $class
     * @param array $params
     */
    static public function setSubClass(&$data, $class, &$params) {
        foreach ($data as $key => &$value) {
            if (isset($value['extends']) && $value['extends'] === $class) {
                $value['attribute'] = array_merge($params['attribute'], $value['attribute']);
                $value['method'] = array_merge($params['method'], $value['method']);
                array_unique($value['method']);
                array_unique($value['attribute']);
                self::setSubClass($data, $key, $value);
            }
        }
    }

    /**
     * 获取节点数据
     * @return array
     */
    static public function getNodeArrayTree() {
        $list = self::getTree(ROOT_PATH);
        $data = [];
        $dirspace = [];
        foreach ($list as $file) {
            $content = file_get_contents($file);
            // 解析空间及名称
            preg_match("|namespace\s*(.*?)\s*;.*?class\s*(\w+)\s*|is", $content, $matches);
            if (count($matches) > 1) {
                $name = "{$matches[1]}\\{$matches[2]}";
                $dir = dirname($file);
                $class = ['method' => [], 'attribute' => [], 'namespace' => $matches[1], 'classname' => $matches[2]];
                $dirspace[$dir] = $matches[1];
                $class['dir'] = $dir;
                // 解析类方法
                preg_match_all("|public\s*function\s*(\w+)\s*\(|is", $content, $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $v) {
                        !in_array($v, ['_initialize', '__construct']) && $class['method'][] = $v;
                    }
                }
                // 解析简单的类属性
                preg_match_all("|public\s*\\$(\w+)\s*=\s*(\w+)\s*;|is", $content, $matches);
                if (!empty($matches[1]) && !empty($matches[2])) {
                    foreach ($matches[1] as $k => $v) {
                        $class['attribute'][$v] = $matches[2][$k];
                    }
                }
                // 类继承分析
                preg_match("|extends\s*(\w+)\s*\{|is", $content, $matches);
                if (!empty($matches[1])) {
                    // 直接继承
                    if ($matches[1][0] === '\\') {
                        $class['extends'] = $matches[1];
                        break;
                    }
                    // use 继承
                    if (preg_match_all("|use\s*([\w\\\]*)\s*\;|is", $content, $use) && !empty($use[1])) {
                        foreach ($use[1] as $c) {
                            $attr = explode('\\', $c);
                            if ($matches[1] === end($attr)) {
                                $class['extends'] = $c;
                                break;
                            }
                        }
                    }
                    // 同空间继续，需要修复
                    empty($class['extends']) && ($class['extends'] = '?' . $matches[1]);
                }
                $data[$name] = $class;
            }
        }
        // 命名空间修复
        foreach ($data as &$vo) {
            if (!empty($vo['extends']) && $vo['extends'][0] === '?' && isset($dirspace[$vo['dir']])) {
                $vo['extends'] = $dirspace[$vo['dir']] . '\\' . trim($vo['extends'], '?');
            }
        }
        // 类继续方法参数合并
        foreach ($data as $key => $value) {
            empty($value['extends']) && self::setSubClass($data, $key, $value);
        }
        // 过滤掉非控制器的域名
        foreach ($data as $k => &$v) {
            if (!preg_match('/app.*?controller/', $k)) {
                unset($data[$k]);
                continue;
            }
            //获取模块名
            $v['module'] = substr(str_replace("app\\", "", $k), 0, strpos(str_replace("app\\", "", $k), "\\"));
        }
        return $data;
    }

}
