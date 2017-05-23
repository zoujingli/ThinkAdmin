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

use Exception;
use OSS\Core\OssException;
use OSS\OssClient;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use think\Config;
use think\Log;

/**
 * 系统文件服务
 * Class FileService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/15 15:17
 */
class FileService {

    /**
     * 根据文件后缀获取文件MINE
     * @param array $exts 文件后缀
     * @param array $mine 文件后缀MINE信息
     * @return string
     */
    public static function getFileMine($exts, $mine = []) {
        $mines = Config::get('mines');
        foreach (is_string($exts) ? explode(',', $exts) : $exts as $_e) {
            if (isset($mines[strtolower($_e)])) {
                $_exinfo = $mines[strtolower($_e)];
                $mine[] = is_array($_exinfo) ? join(',', $_exinfo) : $_exinfo;
            }
        }
        return join(',', $mine);
    }

    /**
     * 获取文件当前URL地址
     * @param string $filename
     * @param string|null $storage
     * @return bool|string
     */
    public static function getFileUrl($filename, $storage = null) {
        if (self::hasFile($filename, $storage) === false) {
            return false;
        }
        switch (empty($storage) ? sysconf('storage_type') : $storage) {
            case 'local':
                return self::getBaseUriLocal() . $filename;
            case 'qiniu':
                return self::getBaseUriQiniu() . $filename;
            case 'oss':
                return self::getBaseUriOss() . $filename;
        }
        return false;
    }

    /**
     * 根据配置获取到七牛云文件上传目标地址
     * @return string
     */
    public static function getUploadLocalUrl() {
        return url('@admin/plugs/upload');
    }

    /**
     * 根据配置获取到七牛云文件上传目标地址
     * @param bool $isClient
     * @return string
     */
    public static function getUploadQiniuUrl($isClient = true) {
        $region = sysconf('storage_qiniu_region');
        $isHttps = !!sysconf('storage_qiniu_is_https');
        switch ($region) {
            case '华东':
                if ($isHttps) {
                    return $isClient ? 'https://upload.qbox.me' : 'https://up.qbox.me';
                }
                return $isClient ? 'http://upload.qiniu.com' : 'http://up.qiniu.com';
            case '华北':
                if ($isHttps) {
                    return $isClient ? 'https://upload-z1.qbox.me' : 'https://up-z1.qbox.me';
                }
                return $isClient ? 'http://upload-z1.qiniu.com' : 'http://up-z1.qiniu.com';
            case '北美':
                if ($isHttps) {
                    return $isClient ? 'https://upload-na0.qbox.me' : 'https://up-na0.qbox.me';
                }
                return $isClient ? 'http://upload-na0.qiniu.com' : 'http://up-na0.qiniu.com';
            case '华南':
            default:
                if ($isHttps) {
                    return $isClient ? 'https://upload-z2.qbox.me' : 'https://up-z2.qbox.me';
                }
                return $isClient ? 'http://upload-z2.qiniu.com' : 'http://up-z2.qiniu.com';
        }
    }

    /**
     * 获取AliOSS上传地址
     * @return string
     */
    public static function getUploadOssUrl() {
        return (request()->isSsl() ? 'https' : 'http') . '://' . sysconf('storage_oss_domain');
    }

    /**
     * 获取服务器URL前缀
     * @return string
     */
    public static function getBaseUriLocal() {
        $request = request();
        $base = $request->root();
        $root = strpos($base, '.') ? ltrim(dirname($base), DS) : $base;
        if ('' != $root) {
            $root = '/' . ltrim($root, '/');
        }
        return ($request->isSsl() ? 'https' : 'http') . '://' . $request->host() . "{$root}/static/upload/";
    }

    /**
     * 获取七牛云URL前缀
     * @return string
     */
    public static function getBaseUriQiniu() {
        return (sysconf('storage_qiniu_is_https') ? 'https' : 'http') . '://' . sysconf('storage_qiniu_domain') . '/';
    }

    /**
     * 获取AliOss URL前缀
     * @return string
     */
    public static function getBaseUriOss() {
        return (sysconf('storage_oss_is_https') ? 'https' : 'http') . '://' . sysconf('storage_oss_domain') . '/';
    }

    /**
     * 获取文件相对名称
     * @param 文件标识 $source
     * @param 文件后缀 $ext
     * @param 文件前缀 $pre
     * @return string
     */
    public static function getFileName($source, $ext = '', $pre = '') {
        return $pre . join('/', str_split(md5($source), 16)) . '.' . $ext;
    }

    /**
     * 检查文件是否已经存在
     * @param string $filename
     * @param string|null $storage
     * @return bool
     */
    public static function hasFile($filename, $storage = null) {
        switch (empty($storage) ? sysconf('storage_type') : $storage) {
            case 'local':
                return file_exists(ROOT_PATH . 'static/upload/' . $filename);
            case 'qiniu':
                $auth = new Auth(sysconf('storage_qiniu_access_key'), sysconf('storage_qiniu_secret_key'));
                $bucketMgr = new BucketManager($auth);
                list($ret, $err) = $bucketMgr->stat(sysconf('storage_qiniu_bucket'), $filename);
                return $err === null;
            case 'oss':
                $ossClient = new OssClient(sysconf('storage_oss_keyid'), sysconf('storage_oss_secret'), self::getBaseUriOss(), true);
                return $ossClient->doesObjectExist(sysconf('storage_oss_bucket'), $filename);
        }
        return false;
    }

    /**
     * 根据Key读取文件内容
     * @param string $filename
     * @param string|null $storage
     * @return string|null
     */
    public static function readFile($filename, $storage = null) {
        switch (empty($storage) ? sysconf('storage_type') : $storage) {
            case 'local':
                $filepath = ROOT_PATH . 'static/upload/' . $filename;
                if (file_exists($filepath)) {
                    return file_get_contents($filepath);
                }
            case 'qiniu':
                $auth = new Auth(sysconf('storage_qiniu_access_key'), sysconf('storage_qiniu_secret_key'));
                return file_get_contents($auth->privateDownloadUrl(self::getBaseUriQiniu() . $filename));
            case 'oss':
                $ossClient = new OssClient(sysconf('storage_oss_keyid'), sysconf('storage_oss_secret'), self::getBaseUriOss(), true);
                return $ossClient->getObject(sysconf('storage_oss_bucket'), $filename);
        }
        Log::error("通过{$storage}读取文件{$filename}的不存在！");
        return null;
    }

    /**
     * 根据当前配置存储文件
     * @param string $filename
     * @param string $content
     * @param string|null $file_storage
     * @return array|false
     */
    public static function save($filename, $content, $file_storage = null) {
        $type = empty($file_storage) ? sysconf('storage_type') : $file_storage;
        if (!method_exists(__CLASS__, $type)) {
            Log::error("保存存储失败，调用{$type}存储引擎不存在！");
            return false;
        }
        return self::$type($filename, $content);
    }

    /**
     * 文件储存在本地
     * @param string $filename
     * @param string $content
     * @return array|null
     */
    public static function local($filename, $content) {
        try {
            $filepath = ROOT_PATH . 'static/upload/' . $filename;
            !file_exists(dirname($filepath)) && mkdir(dirname($filepath), '0755', true);
            if (file_put_contents($filepath, $content)) {
                $url = pathinfo(request()->baseFile(true), PATHINFO_DIRNAME) . '/static/upload/' . $filename;
                return ['file' => $filepath, 'hash' => md5_file($filepath), 'key' => "static/upload/{$filename}", 'url' => $url];
            }
        } catch (Exception $err) {
            Log::error('本地文件存储失败, ' . var_export($err, true));
        }
        return null;
    }

    /**
     * 七牛云存储
     * @param string $filename
     * @param string $content
     * @return array|null
     */
    public static function qiniu($filename, $content) {
        $auth = new Auth(sysconf('storage_qiniu_access_key'), sysconf('storage_qiniu_secret_key'));
        $token = $auth->uploadToken(sysconf('storage_qiniu_bucket'));
        $uploadMgr = new UploadManager();
        list($result, $err) = $uploadMgr->put($token, $filename, $content);
        if ($err !== null) {
            Log::error('七牛云文件上传失败, ' . var_export($err, true));
            return null;
        }
        $result['file'] = $filename;
        $result['url'] = self::getBaseUriQiniu() . $filename;
        return $result;
    }

    /**
     * 阿里云OSS
     * @param string $filename
     * @param string $content
     * @return array|null
     */
    public static function oss($filename, $content) {
        try {
            $ossClient = new OssClient(sysconf('storage_oss_keyid'), sysconf('storage_oss_secret'), self::getBaseUriOss(), true);
            $result = $ossClient->putObject(sysconf('storage_oss_bucket'), $filename, $content);
            return ['file' => $filename, 'hash' => $result['content-md5'], 'key' => $filename, 'url' => $result['oss-request-url']];
        } catch (OssException $err) {
            Log::error('阿里云OSS文件上传失败, ' . var_export($err, true));
            return null;
        }
    }

    /**
     * 下载文件到本地
     * @param string $url 文件URL地址
     * @param bool $isForce 是否强制重新下载文件
     * @return array|null;
     */
    public static function download($url, $isForce = false) {
        try {
            $filename = self::getFileName($url, strtolower(pathinfo($url, 4)), 'download/');
            if (false === $isForce && ($siteUrl = self::getFileUrl($filename, 'local'))) {
                $realfile = ROOT_PATH . 'static/upload/' . $filename;
                return ['file' => $realfile, 'hash' => md5_file($realfile), 'key' => "static/upload/{$filename}", 'url' => $siteUrl];
            }
            return self::local($filename, file_get_contents($url));
        } catch (\Exception $e) {
            Log::error("FileService 文件下载失败 [ {$url} ] . {$e->getMessage()}");
            return false;
        }
    }

}
