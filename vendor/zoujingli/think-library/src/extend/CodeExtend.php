<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\extend;

/**
 * 随机数码管理扩展
 * Class CodeExtend
 * @package think\admin\extend
 */
class CodeExtend
{
    /**
     * 获取随机字符串编码
     * @param integer $size 字符串长度
     * @param integer $type 字符串类型(1纯数字,2纯字母,3数字字母)
     * @return string
     */
    public static function random($size = 10, $type = 1)
    {
        $numbs = '0123456789';
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        if (intval($type) === 1) $chars = $numbs;
        if (intval($type) === 2) $chars = "a{$chars}";
        if (intval($type) === 3) $chars = "{$numbs}{$chars}";
        $string = $chars[rand(1, strlen($chars) - 1)];
        if (isset($chars)) while (strlen($string) < $size) {
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $string;
    }

    /**
     * 唯一日期编码
     * @param integer $size
     * @return string
     */
    public static function uniqidDate($size = 16)
    {
        if ($size < 14) $size = 14;
        $string = date('Ymd') . (date('H') + date('i')) . date('s');
        while (strlen($string) < $size) $string .= rand(0, 9);
        return $string;
    }

    /**
     * 唯一数字编码
     * @param integer $size
     * @return string
     */
    public static function uniqidNumber($size = 12)
    {
        $time = time() . '';
        if ($size < 10) $size = 10;
        $string = ($time[0] + $time[1]) . substr($time, 2) . rand(0, 9);
        while (strlen($string) < $size) $string .= rand(0, 9);
        return $string;
    }
}