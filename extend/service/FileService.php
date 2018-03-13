<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace service;

use Exception;
use OSS\Core\OssException;
use OSS\OssClient;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use think\facade\Log;

/**
 * 系统文件服务
 * Class FileService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/15 15:17
 */
class FileService
{

    /**
     * 根据文件后缀获取文件MINE
     * @param array $ext 文件后缀
     * @param array $mine 文件后缀MINE信息
     * @return string
     */
    public static function getFileMine($ext, $mine = [])
    {
        $mines = self::getMines();
        foreach (is_string($ext) ? explode(',', $ext) : $ext as $e) {
            $mine[] = isset($mines[strtolower($e)]) ? $mines[strtolower($e)] : 'application/octet-stream';
        }
        return join(',', array_unique($mine));
    }

    /**
     * 获取所有文件扩展的mine
     * @return mixed
     */
    public static function getMines()
    {
        $mines = cache('all_ext_mine');
        if (empty($mines)) {
            $content = file_get_contents('http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types');
            preg_match_all('#^([^\s]{2,}?)\s+(.+?)$#ism', $content, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                foreach (explode(" ", $match[2]) as $ext) {
                    $mines[$ext] = $match[1];
                }
            }
            cache('all_ext_mine', $mines);
        }
        return $mines;
    }

    /**
     * 获取文件当前URL地址
     * @param string $filename
     * @param string|null $storage
     * @return bool|string
     * @throws OssException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getFileUrl($filename, $storage = null)
    {
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
    public static function getUploadLocalUrl()
    {
        return url('@admin/plugs/upload');
    }

    /**
     * 根据配置获取到七牛云文件上传目标地址
     * @param bool $isClient
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getUploadQiniuUrl($isClient = true)
    {
        $region = sysconf('storage_qiniu_region');
        $isHttps = !!sysconf('storage_qiniu_is_https');
        switch ($region) {
            case '华东':
                if ($isHttps) {
                    return $isClient ? 'https:///upload.qiniup.com' : 'https://upload.qiniup.com';
                }
                return $isClient ? 'http:///upload.qiniup.com' : 'http://upload.qiniup.com';
            case '华北':
                if ($isHttps) {
                    return $isClient ? 'https://upload-z1.qiniup.com' : 'https://up-z1.qiniup.com';
                }
                return $isClient ? 'http://upload-z1.qiniup.com' : 'http://up-z1.qiniup.com';
            case '北美':
                if ($isHttps) {
                    return $isClient ? 'https://upload-na0.qiniup.com' : 'https://up-na0.qiniup.com';
                }
                return $isClient ? 'http://upload-na0.qiniup.com' : 'http://up-na0.qiniup.com';
            case '华南':
            default:
                if ($isHttps) {
                    return $isClient ? 'https://upload-z2.qiniup.com' : 'https://up-z2.qiniup.com';
                }
                return $isClient ? 'http://upload-z2.qiniup.com' : 'http://up-z2.qiniup.com';
        }
    }

    /**
     * 获取AliOSS上传地址
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getUploadOssUrl()
    {
        $protocol = request()->isSsl() ? 'https' : 'http';
        return "{$protocol}://" . sysconf('storage_oss_domain');
    }

    /**
     * 获取服务器URL前缀
     * @return string
     */
    public static function getBaseUriLocal()
    {
        $appRoot = request()->root(true);
        $uriRoot = preg_match('/\.php$/', $appRoot) ? dirname($appRoot) : $appRoot;
        return "{$uriRoot}/static/upload/";
    }

    /**
     * 获取七牛云URL前缀
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getBaseUriQiniu()
    {
        switch (strtolower(sysconf('storage_qiniu_is_https'))) {
            case 'https':
                return 'https://' . sysconf('storage_qiniu_domain') . '/';
            case 'http':
                return 'http://' . sysconf('storage_qiniu_domain') . '/';
            default:
                return '//' . sysconf('storage_qiniu_domain') . '/';
        }
    }

    /**
     * 获取阿里云对象存储URL前缀
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function getBaseUriOss()
    {
        switch (strtolower(sysconf('storage_oss_is_https'))) {
            case 'https':
                return 'https://' . sysconf('storage_oss_domain') . '/';
            case 'http':
                return 'http://' . sysconf('storage_oss_domain') . '/';
            default:
                return '//' . sysconf('storage_oss_domain') . '/';
        }
    }

    /**
     * 获取文件相对名称
     * @param string $local_url 文件标识
     * @param string $ext 文件后缀
     * @param string $pre 文件前缀（若有值需要以/结尾）
     * @return string
     */
    public static function getFileName($local_url, $ext = '', $pre = '')
    {
        empty($ext) && $ext = strtolower(pathinfo($local_url, 4));
        return $pre . join('/', str_split(md5($local_url), 16)) . '.' . ($ext ? $ext : 'tmp');
    }

    /**
     * 检查文件是否已经存在
     * @param string $filename
     * @param string|null $storage
     * @return bool
     * @throws OssException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function hasFile($filename, $storage = null)
    {
        switch (empty($storage) ? sysconf('storage_type') : $storage) {
            case 'local':
                return file_exists(env('root_path') . 'static/upload/' . $filename);
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
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @throws OssException
     */
    public static function readFile($filename, $storage = null)
    {
        switch (empty($storage) ? sysconf('storage_type') : $storage) {
            case 'local':
                $file = env('root_path') . 'static/upload/' . $filename;
                return file_exists($file) ? file_get_contents($file) : '';
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
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function save($filename, $content, $file_storage = null)
    {
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
    public static function local($filename, $content)
    {
        try {
            $realfile = env('root_path') . 'static/upload/' . $filename;
            !file_exists(dirname($realfile)) && mkdir(dirname($realfile), 0755, true);
            if (file_put_contents($realfile, $content)) {
                $url = pathinfo(request()->baseFile(true), PATHINFO_DIRNAME) . '/static/upload/' . $filename;
                return ['file' => $realfile, 'hash' => md5_file($realfile), 'key' => "static/upload/{$filename}", 'url' => $url];
            }
        } catch (Exception $err) {
            Log::error('本地文件存储失败, ' . $err->getMessage());
        }
        return null;
    }

    /**
     * 七牛云存储
     * @param string $filename
     * @param string $content
     * @return array|null
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function qiniu($filename, $content)
    {
        $auth = new Auth(sysconf('storage_qiniu_access_key'), sysconf('storage_qiniu_secret_key'));
        $token = $auth->uploadToken(sysconf('storage_qiniu_bucket'));
        $uploadMgr = new UploadManager();
        list($result, $err) = $uploadMgr->put($token, $filename, $content);
        if ($err !== null) {
            Log::error('七牛云文件上传失败, ' . $err->getMessage());
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
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function oss($filename, $content)
    {
        try {
            $endpoint = 'http://' . sysconf('storage_oss_domain');
            $ossClient = new OssClient(sysconf('storage_oss_keyid'), sysconf('storage_oss_secret'), $endpoint, true);
            $result = $ossClient->putObject(sysconf('storage_oss_bucket'), $filename, $content);
            $baseUrl = explode('://', $result['oss-request-url'])[1];
            if (strtolower(sysconf('storage_oss_is_https')) === 'http') {
                $site_url = "http://{$baseUrl}";
            } elseif (strtolower(sysconf('storage_oss_is_https')) === 'https') {
                $site_url = "https://{$baseUrl}";
            } else {
                $site_url = "//{$baseUrl}";
            }
            return ['file' => $filename, 'hash' => $result['content-md5'], 'key' => $filename, 'url' => $site_url];
        } catch (OssException $err) {
            Log::error('阿里云OSS文件上传失败, ' . $err->getMessage());
        }
        return null;
    }

    /**
     * 下载文件到本地
     * @param string $url 文件URL地址
     * @param bool $isForce 是否强制重新下载文件
     * @return array
     */
    public static function download($url, $isForce = false)
    {
        try {
            $filename = self::getFileName($url, '', 'download/');
            if (false === $isForce && ($siteUrl = self::getFileUrl($filename, 'local'))) {
                $realfile = env('root_path') . 'static/upload/' . $filename;
                return ['file' => $realfile, 'hash' => md5_file($realfile), 'key' => "static/upload/{$filename}", 'url' => $siteUrl];
            }
            return self::local($filename, file_get_contents($url));
        } catch (\Exception $e) {
            Log::error("FileService 文件下载失败 [ {$url} ] " . $e->getMessage());
        }
        return ['url' => $url];
    }

}
