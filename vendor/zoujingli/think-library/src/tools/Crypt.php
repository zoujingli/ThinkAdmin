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
 * 数据加密解密工具
 * Class Crypt
 * @package library\tools
 */
class Crypt
{
    /**
     * UTF8字符串加密
     * @param string $string
     * @return string
     */
    public static function encode($string)
    {
        list($chars, $length) = ['', strlen($content = iconv('UTF-8', 'GBK//TRANSLIT', $string))];
        for ($i = 0; $i < $length; $i++) $chars .= str_pad(base_convert(ord($content[$i]), 10, 36), 2, 0, 0);
        return $chars;
    }

    /**
     * UTF8字符串解密
     * @param string $encode
     * @return string
     */
    public static function decode($encode)
    {
        $chars = '';
        foreach (str_split($encode, 2) as $char) {
            $chars .= chr(intval(base_convert($char, 36, 10)));
        }
        return iconv('GBK//TRANSLIT', 'UTF-8', $chars);
    }

    /**
     * 静态调用方法处理
     * @param string $name
     * @param string $args
     * @return mixed
     */
    public static function __callStatic($name, $args)
    {
        if (stripos($name, 'emoji') === 0) {
            $method = str_replace('emoji', '', strtolower($name));
            if (in_array($method, ['encode', 'decode', 'clear'])) {
                return Emoji::$method($args[0]);
            }
        }
    }
}
