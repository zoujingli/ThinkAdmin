<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace library;

use CURLFile;

/**
 * HTTP模拟请求
 *
 * @package library
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/11/15 09:53
 */
class Http {

    /**
     * HTTP GET 请求
     * @param string $url 请求的URL地址
     * @param array $data GET参数
     * @param int $second 设置超时时间（默认30秒）
     * @param array $header 请求Header信息
     * @return bool|string
     */
    static public function get($url, $data = array(), $second = 30, $header = []) {
        if (!empty($data)) {
            $url .= (stripos($url, '?') === FALSE ? '?' : '&');
            $url .= (is_array($data) ? http_build_query($data) : $data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, $second);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        self::_set_ssl($curl, $url);
        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        if (intval($status["http_code"]) == 200) {
            return $content;
        } else {
            return false;
        }
    }

    /**
     * 设置SSL参数
     * @param $curl
     * @param string $url
     */
    static private function _set_ssl(&$curl, $url) {
        if (stripos($url, "https") === 0) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSLVERSION, 1);
        }
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
        self::_set_upload($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, $second);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        if (!empty($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        self::_set_ssl($curl, $url);
        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        if (intval($status["http_code"]) == 200) {
            return $content;
        } else {
            return false;
        }
    }

    /**
     * 设置POST文件上传兼容
     * @param array $data
     * @return string
     */
    static private function _set_upload(&$data) {
        if (is_array($data)) {
            foreach ($data as &$value) {
                if (!is_string($value) || stripos($value, '@') !== 0) {
                    continue;
                }
                $filename = realpath(trim($value, '@'));
                $filemime = self::_get_file_mimes($filename);
                $value = class_exists('CURLFile', FALSE) ? new CURLFile($filename, $filemime) : "{$value};type={$filemime}";
            }
        }
    }

    /**
     * 文件上传MIMS设置
     * @param $file
     * @return string
     */
    static private function _get_file_mimes($file) {
        $mimes = require(__DIR__ . DS . 'resource' . DS . 'mines.php');
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (isset($mimes[$ext])) {
            return is_array($mimes[$ext]) ? $mimes[$ext][0] : $mimes[$ext];
        } else {
            return 'application/octet-stream';
        }
    }

}
