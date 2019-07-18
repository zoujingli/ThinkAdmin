<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\tools;

/**
 * 处理 Emoji 表情
 * Class Emoji
 * @package library\tools
 */
class Emoji
{
    /**
     * Emoji原形转换为String
     * @param string $content
     * @return string
     */
    public static function encode($content)
    {
        return json_decode(preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i", function ($maps) {
            return addslashes($maps[0]);
        }, json_encode($content)));
    }

    /**
     * Emoji字符串转换为原形
     * @param string $content
     * @return string
     */
    public static function decode($content)
    {
        return json_decode(preg_replace_callback('/\\\\\\\\/i', function () {
            return '\\';
        }, json_encode($content)));
    }

    /**
     * Emoji字符串清清理
     * @param string $content
     * @return string
     */
    public static function clear($content)
    {
        return preg_replace_callback('/./u', function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        }, $content);
    }
}
