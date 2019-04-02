<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\tools;

/**
 * CURL数据请求管理器
 * Class Http
 * @package library\tools
 */
class Http
{
    /**
     * 以get模拟网络请求
     * @param string $url HTTP请求URL地址
     * @param array $query GET请求参数
     * @param array $options CURL参数
     * @return boolean|string
     */
    public static function get($url, $query = [], $options = [])
    {
        $options['query'] = $query;
        return self::request('get', $url, $options);
    }

    /**
     * 以get模拟网络请求
     * @param string $url HTTP请求URL地址
     * @param array $data POST请求数据
     * @param array $options CURL参数
     * @return boolean|string
     */
    public static function post($url, $data = [], $options = [])
    {
        $options['data'] = $data;
        return self::request('post', $url, $options);
    }

    /**
     * CURL模拟网络请求
     * @param string $method 请求方法
     * @param string $url 请求方法
     * @param array $options 请求参数[headers,data]
     * @return boolean|string
     */
    public static function request($method, $url, $options = [])
    {
        $curl = curl_init();
        // GET 参数设置
        if (!empty($options['query'])) {
            $url .= (stripos($url, '?') !== false ? '&' : '?') . http_build_query($options['query']);
        }
        // 浏览器代理设置
        curl_setopt($curl, CURLOPT_USERAGENT, self::getUserAgent());
        // CURL 头信息设置
        if (!empty($options['headers'])) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $options['headers']);
        }
        // Cookie 信息设置
        if (!empty($options['cookie'])) {
            curl_setopt($curl, CURLOPT_COOKIE, $options['cookie']);
        }
        // POST 数据设置
        if (strtolower($method) === 'post') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, self::_buildHttpData($options['data']));
        }
        // 请求超时设置
        if (isset($options['timeout']) && is_numeric($options['timeout'])) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $options['timeout']);
        } else {
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $content = curl_exec($curl);
        curl_close($curl);
        return $content;
    }

    /**
     * POST数据过滤处理
     * @param array $data 需要处理的数据
     * @param boolean $build 是否编译数据
     * @return array|string
     */
    private static function _buildHttpData($data, $build = true)
    {
        if (!is_array($data)) return $data;
        foreach ($data as $key => $value) if (is_object($value) && $value instanceof \CURLFile) {
            $build = false;
        } elseif (is_string($value) && class_exists('CURLFile', false) && stripos($value, '@') === 0) {
            if (($filename = realpath(trim($value, '@'))) && file_exists($filename)) {
                list($build, $data[$key]) = [false, new \CURLFile($filename)];
            }
        }
        return $build ? http_build_query($data) : $data;
    }


    /**
     * 获取浏览器代理信息
     * @return string
     */
    private static function getUserAgent()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) return $_SERVER['HTTP_USER_AGENT'];
        $userAgents = [
            "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
            "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
            "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
            "Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
        ];
        return $userAgents[array_rand($userAgents, 1)];
    }

}