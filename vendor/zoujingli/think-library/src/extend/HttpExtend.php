<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\extend;

/**
 * CURL模拟请求扩展
 * Class HttpExtend
 * @package think\admin\extend
 */
class HttpExtend
{
    /**
     * 以 GET 模拟网络请求
     * @param string $location HTTP请求地址
     * @param array|string $data GET请求参数
     * @param array $options CURL请求参数
     * @return boolean|string
     */
    public static function get(string $location, $data = [], array $options = [])
    {
        $options['query'] = $data;
        return static::request('get', $location, $options);
    }

    /**
     * 以 POST 模拟网络请求
     * @param string $location HTTP请求地址
     * @param array|string $data POST请求数据
     * @param array $options CURL请求参数
     * @return boolean|string
     */
    public static function post(string $location, $data = [], array $options = [])
    {
        $options['data'] = $data;
        return static::request('post', $location, $options);
    }

    /**
     * 以 FormData 模拟网络请求
     * @param string $url 模拟请求地址
     * @param array $data 模拟请求参数数据
     * @param array $file 提交文件 [field,name,content]
     * @param array $header 请求头部信息，默认带 Content-type
     * @param string $method 模拟请求的方式 [GET,POST,PUT]
     * @param boolean $returnHeader 是否返回头部信息
     * @return boolean|string
     */
    public static function submit(string $url, array $data = [], array $file = [], array $header = [], string $method = 'POST', bool $returnHeader = true)
    {
        [$line, $boundary] = [[], CodeExtend::random(18)];
        foreach ($data as $key => $value) {
            $line[] = "--{$boundary}";
            $line[] = "Content-Disposition: form-data; name=\"{$key}\"";
            $line[] = "";
            $line[] = $value;
        }
        if (is_array($file) && isset($file['field']) && isset($file['name'])) {
            $line[] = "--{$boundary}";
            $line[] = "Content-Disposition: form-data; name=\"{$file['field']}\"; filename=\"{$file['name']}\"";
            $line[] = "";
            $line[] = $file['content'];
        }
        $line[] = "--{$boundary}--";
        $header[] = "Content-type:multipart/form-data;boundary={$boundary}";
        return static::request($method, $url, ['data' => join("\r\n", $line), 'returnHeader' => $returnHeader, 'headers' => $header]);
    }

    /**
     * 以 CURL 模拟网络请求
     * @param string $method 模拟请求方式
     * @param string $location 模拟请求地址
     * @param array $options 请求参数[headers,query,data,cookie,cookie_file,timeout,returnHeader]
     * @return boolean|string
     */
    public static function request(string $method, string $location, array $options = [])
    {
        // GET 参数设置
        if (!empty($options['query'])) {
            $location .= strpos($location, '?') !== false ? '&' : '?';
            if (is_array($options['query'])) {
                $location .= http_build_query($options['query']);
            } elseif (is_string($options['query'])) {
                $location .= $options['query'];
            }
        }
        $curl = curl_init();
        // Agent 代理设置
        curl_setopt($curl, CURLOPT_USERAGENT, static::getUserAgent());
        // Cookie 信息设置
        if (!empty($options['cookie'])) {
            curl_setopt($curl, CURLOPT_COOKIE, $options['cookie']);
        }
        // Header 头信息设置
        if (!empty($options['headers'])) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $options['headers']);
        }
        if (!empty($options['cookie_file'])) {
            curl_setopt($curl, CURLOPT_COOKIEJAR, $options['cookie_file']);
            curl_setopt($curl, CURLOPT_COOKIEFILE, $options['cookie_file']);
        }
        // 设置请求方式
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        if (strtolower($method) === 'head') {
            curl_setopt($curl, CURLOPT_NOBODY, 1);
        } elseif (isset($options['data'])) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $options['data']);
        }
        // 请求超时设置
        if (isset($options['timeout']) && is_numeric($options['timeout'])) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $options['timeout']);
        } else {
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        }
        // 是否返回前部内容
        if (empty($options['returnHeader'])) {
            curl_setopt($curl, CURLOPT_HEADER, false);
        } else {
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        }
        curl_setopt($curl, CURLOPT_URL, $location);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        [$content] = [curl_exec($curl), curl_close($curl)];
        return $content;
    }

    /**
     * 获取浏览器代理信息
     * @return string
     */
    private static function getUserAgent(): string
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) return $_SERVER['HTTP_USER_AGENT'];
        $agents = [
            "Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
            "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
            "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
        ];
        return $agents[array_rand($agents, 1)];
    }
}