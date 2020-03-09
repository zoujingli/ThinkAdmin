<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\tools;

use think\Db;
use think\db\Query;

/**
 * Class Data
 * @package library\tools
 */
class Data
{
    /**
     * 数据增量保存
     * @param Query|string $dbQuery 数据查询对象
     * @param array $data 需要保存或更新的数据
     * @param string $key 条件主键限制
     * @param array $where 其它的where条件
     * @return boolean|integer
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function save($dbQuery, $data, $key = 'id', $where = [])
    {
        $db = is_string($dbQuery) ? Db::name($dbQuery) : $dbQuery;
        list($table, $value) = [$db->getTable(), isset($data[$key]) ? $data[$key] : null];
        $map = isset($where[$key]) ? [] : (is_string($value) ? [[$key, 'in', explode(',', $value)]] : [$key => $value]);
        if (is_array($info = Db::table($table)->master()->where($where)->where($map)->find()) && !empty($info)) {
            if (Db::table($table)->strict(false)->where($where)->where($map)->update($data) !== false) {
                return isset($info[$key]) ? $info[$key] : true;
            } else {
                return false;
            }
        } else {
            return Db::table($table)->strict(false)->insertGetId($data);
        }
    }

    /**
     * 批量更新数据
     * @param Query|string $dbQuery 数据查询对象
     * @param array $data 需要更新的数据(二维数组)
     * @param string $key 条件主键限制
     * @param array $where 其它的where条件
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function batchSave($dbQuery, $data, $key = 'id', $where = [])
    {
        list($case, $input) = [[], []];
        foreach ($data as $row) foreach ($row as $key => $value) {
            $case[$key][] = "WHEN '{$row[$key]}' THEN '{$value}'";
        }
        if (isset($case[$key])) unset($case[$key]);
        $db = is_string($dbQuery) ? Db::name($dbQuery) : $dbQuery;
        foreach ($case as $key => $value) $input[$key] = $db->raw("CASE `{$key}` " . join(' ', $value) . ' END');
        return $db->whereIn($key, array_unique(array_column($data, $key)))->where($where)->update($input) !== false;
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     * @return array
     */
    public static function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) $map[$item[$id]] = $item;
        foreach ($list as $item) if (isset($item[$pid]) && isset($map[$item[$pid]])) {
            $map[$item[$pid]][$son][] = &$map[$item[$id]];
        } else $tree[] = &$map[$item[$id]];
        unset($map);
        return $tree;
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id ID Key
     * @param string $pid 父ID Key
     * @param string $path
     * @param string $ppath
     * @return array
     */
    public static function arr2table(array $list, $id = 'id', $pid = 'pid', $path = 'path', $ppath = '')
    {
        $tree = [];
        foreach (self::arr2tree($list, $id, $pid) as $attr) {
            $attr[$path] = "{$ppath}-{$attr[$id]}";
            $attr['sub'] = isset($attr['sub']) ? $attr['sub'] : [];
            $attr['spt'] = substr_count($ppath, '-');
            $attr['spl'] = str_repeat("　├　", $attr['spt']);
            $sub = $attr['sub'];
            unset($attr['sub']);
            $tree[] = $attr;
            if (!empty($sub)) $tree = array_merge($tree, self::arr2table($sub, $id, $pid, $path, $attr[$path]));
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
    public static function getArrSubIds($list, $id = 0, $key = 'id', $pkey = 'pid')
    {
        $ids = [intval($id)];
        foreach ($list as $vo) if (intval($vo[$pkey]) > 0 && intval($vo[$pkey]) === intval($id)) {
            $ids = array_merge($ids, self::getArrSubIds($list, intval($vo[$key]), $key, $pkey));
        }
        return $ids;
    }

    /**
     * 唯一数字编码
     * @param integer $length
     * @return string
     */
    public static function uniqidNumberCode($length = 10)
    {
        $time = time() . '';
        if ($length < 10) $length = 10;
        $string = ($time[0] + $time[1]) . substr($time, 2) . rand(0, 9);
        while (strlen($string) < $length) $string .= rand(0, 9);
        return $string;
    }

    /**
     * 唯一日期编码
     * @param integer $length
     * @return string
     */
    public static function uniqidDateCode($length = 14)
    {
        if ($length < 14) $length = 14;
        $string = date('Ymd') . (date('H') + date('i')) . date('s');
        while (strlen($string) < $length) $string .= rand(0, 9);
        return $string;
    }

    /**
     * 获取随机字符串编码
     * @param integer $length 字符串长度
     * @param integer $type 字符串类型(1纯数字,2纯字母,3数字字母)
     * @return string
     */
    public static function randomCode($length = 10, $type = 1)
    {
        $numbs = '0123456789';
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        if (intval($type) === 1) $chars = $numbs;
        if (intval($type) === 2) $chars = "a{$chars}";
        if (intval($type) === 3) $chars = "{$numbs}{$chars}";
        $string = $chars[rand(1, strlen($chars) - 1)];
        if (isset($chars)) while (strlen($string) < $length) {
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $string;
    }

    /**
     * 文件大小显示转换
     * @param integer $size 文件大小
     * @param integer $deci 小数位数
     * @return string
     */
    public static function toFileSize($size, $deci = 2)
    {
        list($pos, $map) = [0, ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB']];
        while ($size >= 1024 && $pos < 6) if (++$pos) $size /= 1024;
        return round($size, $deci) . ' ' . $map[$pos];
    }
}
