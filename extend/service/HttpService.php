<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace service;

use CURLFile;

/**
 * HTTP请求服务
 * Class HttpService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/22 15:32
 */
class HttpService {

    /**
     * HTTP GET 请求
     * @param string $url 请求的URL地址
     * @param array $data GET参数
     * @param int $second 设置超时时间（默认30秒）
     * @param array $header 请求Header信息
     * @return bool|string
     */
    public static function get($url, $data = array(), $second = 30, $header = []) {
        if (!empty($data)) {
            $url .= (stripos($url, '?') === false ? '?' : '&');
            $url .= (is_array($data) ? http_build_query($data) : $data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, $second);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        !empty($header) && curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        self::_setSsl($curl, $url);
        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        return (intval($status["http_code"]) === 200) ? $content : false;
    }

    /**
     * POST 请求（支持文件上传）
     * @param string $url HTTP请求URL地址
     * @param array|string $data POST提交的数据
     * @param int $second 请求超时时间
     * @param array $header 请求Header信息
     * @return bool|string
     */
    static public function post($url, $data = [], $second = 30, $header = []) {
        self::_setUploadFile($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, $second);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        !empty($header) && curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        self::_setSsl($curl, $url);
        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        return (intval($status["http_code"]) === 200) ? $content : false;
    }

    /**
     * 设置SSL参数
     * @param $curl
     * @param string $url
     */
    private static function _setSsl(&$curl, $url) {
        if (stripos($url, "https") === 0) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSLVERSION, 1);
        }
    }

    /**
     * 设置POST文件上传兼容
     * @param array $data
     * @return string
     */
    private static function _setUploadFile(&$data) {
        if (!is_array($data)) {
            return null;
        }
        foreach ($data as &$value) {
            if (!(is_string($value) && strlen($value) > 0 && $value[0] === '@')) {
                continue;
            }
            $filename = realpath(trim($value, '@'));
            $filemime = FileService::getFileMine(strtolower(pathinfo($filename, PATHINFO_EXTENSION)));
            $value = class_exists('CURLFile', false) ? new CURLFile($filename, $filemime) : "{$value};type={$filemime}";
        }
    }

}
