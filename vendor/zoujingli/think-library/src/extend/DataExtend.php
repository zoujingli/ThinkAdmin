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

namespace think\admin\extend;

/**
 * 数据处理扩展
 * Class DataExtend
 * @package think\admin\extend
 */
class DataExtend
{

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $key ID_KEY
     * @param string $pkey PID_KEY
     * @param string $skey 子数据名称
     * @return array
     */
    public static function arr2tree($list, $key = 'id', $pkey = 'pid', $skey = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) $map[$item[$key]] = $item;
        foreach ($list as $item) if (isset($item[$pkey]) && isset($map[$item[$pkey]])) {
            $map[$item[$pkey]][$skey][] = &$map[$item[$key]];
        } else $tree[] = &$map[$item[$key]];
        unset($map);
        return $tree;
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $key ID_KEY
     * @param string $pkey PID_KEY
     * @param string $path
     * @param string $ppath
     * @return array
     */
    public static function arr2table(array $list, $key = 'id', $pkey = 'pid', $path = 'path', $ppath = '')
    {
        $tree = [];
        foreach (self::arr2tree($list, $key, $pkey) as $attr) {
            $attr[$path] = "{$ppath}-{$attr[$key]}";
            $attr['sub'] = isset($attr['sub']) ? $attr['sub'] : [];
            $attr['spt'] = substr_count($ppath, '-');
            $attr['spl'] = str_repeat("　├　", $attr['spt']);
            $sub = $attr['sub'];
            unset($attr['sub']);
            $tree[] = $attr;
            if (!empty($sub)) $tree = array_merge($tree, self::arr2table($sub, $key, $pkey, $path, $attr[$path]));
        }
        return $tree;
    }

    /**
     * 获取数据树子ID
     * @param array $list 数据列表
     * @param integer $id 起始ID
     * @param string $key ID_KEY
     * @param string $pkey PID_KEY
     * @return array
     */
    public static function getArrSubIds($list, $id = 0, $key = 'id', $pkey = 'pid')
    {
        $ids = [intval($id)];
        foreach ($list as $vo) if (intval($vo[$pkey]) > 0 && intval($vo[$pkey]) === intval($id)) {
            $ids = array_merge($ids, self::getArrSubIds($list, intval($vo[$key]), $key, $pkey));
        }
        return $ids;
    }
}