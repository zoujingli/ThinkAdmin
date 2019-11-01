<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

use think\admin\extend\DataExtend;
use think\admin\extend\HttpExtend;
use think\admin\extend\TokenExtend;
use think\db\Query;

if (!function_exists('p')) {
    /**
     * 打印输出数据到文件
     * @param mixed $data 输出的数据
     * @param boolean $replace 强制替换
     * @param string|null $file 文件名称
     */
    function p($data, $replace = false, $file = null)
    {
        if (is_null($file)) $file = env('runtime_path') . date('Ymd') . '.txt';
        $str = (is_string($data) ? $data : (is_array($data) || is_object($data)) ? print_r($data, true) : var_export($data, true)) . PHP_EOL;
        $replace ? file_put_contents($file, $str) : file_put_contents($file, $str, FILE_APPEND);
    }
}

if (!function_exists('systoken')) {
    /**
     * 生成 CSRF-TOKEN 参数
     * @param string $node
     * @return string
     */
    function systoken($node = null)
    {
        return TokenExtend::buildFormToken($node)['token'];
    }
}

if (!function_exists('format_datetime')) {
    /**
     * 日期格式标准输出
     * @param string $datetime 输入日期
     * @param string $format 输出格式
     * @return false|string
     */
    function format_datetime($datetime, $format = 'Y年m月d日 H:i:s')
    {
        if (empty($datetime)) return '-';
        if (is_numeric($datetime)) {
            return date($format, $datetime);
        } else {
            return date($format, strtotime($datetime));
        }
    }
}

if (!function_exists('sysconf')) {
    /**
     * 设备或配置系统参数
     * @param string $name 参数名称
     * @param string $value 参数内容
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function sysconf($name = '', $value = null)
    {
        $type = 'base';
        static $data = [];
        if (stripos($name, '.') !== false) {
            list($type, $name) = explode('.', $name);
        }
        list($field, $filter) = explode('|', "{$name}|");
        if (!empty($field) && !empty($value)) {
            if (is_array($value)) {
                foreach ($value as $k => $v) sysconf("{$field}.{$k}", $v);
            } else {
                list($row, $data) = [['name' => $field, 'value' => $value, 'type' => $type], []];
                return DataExtend::save('SystemConfig', $row, 'name', ['type' => $type]);
            }
        } else {
            if (empty($data)) foreach (app()->db->name('SystemConfig')->select()->toArray() as $vo) {
                $data[$vo['type']][$vo['name']] = $vo['value'];
            }
            if (empty($name)) {
                return empty($data[$type]) ? [] : (strtolower($filter) === 'raw' ? $data[$type] : array_map(function ($value) {
                    return htmlspecialchars($value);
                }, $data[$type]));
            } else {
                if (isset($data[$type]) && isset($data[$type][$field])) {
                    return strtolower($filter) === 'raw' ? $data[$type][$field] : htmlspecialchars($data[$type][$field]);
                } else return '';
            }
        }
    }
}

if (!function_exists('http_get')) {
    /**
     * 以get模拟网络请求
     * @param string $url HTTP请求URL地址
     * @param array|string $query GET请求参数
     * @param array $options CURL参数
     * @return boolean|string
     */
    function http_get($url, $query = [], $options = [])
    {
        return HttpExtend::get($url, $query, $options);
    }
}

if (!function_exists('http_post')) {
    /**
     * 以post模拟网络请求
     * @param string $url HTTP请求URL地址
     * @param array|string $data POST请求数据
     * @param array $options CURL参数
     * @return boolean|string
     */
    function http_post($url, $data, $options = [])
    {
        return HttpExtend::post($url, $data, $options);
    }
}

if (!function_exists('data_save')) {
    /**
     * 数据增量保存
     * @param Query|string $dbQuery
     * @param array $data 需要保存或更新的数据
     * @param string $key 条件主键限制
     * @param array $where 其它的where条件
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function data_save($dbQuery, $data, $key = 'id', $where = [])
    {
        return DataExtend::save($dbQuery, $data, $key, $where);
    }
}

if (!function_exists('encode')) {
    /**
     * 加密 UTF8 字符串
     * @param string $content
     * @return string
     */
    function encode($content)
    {
        list($chars, $length) = ['', strlen($string = iconv('UTF-8', 'GBK//TRANSLIT', $content))];
        for ($i = 0; $i < $length; $i++) $chars .= str_pad(base_convert(ord($string[$i]), 10, 36), 2, 0, 0);
        return $chars;
    }
}

if (!function_exists('decode')) {
    /**
     * 解密 UTF8 字符串
     * @param string $content
     * @return string
     */
    function decode($content)
    {
        $chars = '';
        foreach (str_split($content, 2) as $char) {
            $chars .= chr(intval(base_convert($char, 36, 10)));
        }
        return iconv('GBK//TRANSLIT', 'UTF-8', $chars);
    }
}