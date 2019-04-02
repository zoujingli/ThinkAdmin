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

namespace library\driver;

use library\File;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use think\facade\Log;

/**
 * 七牛云文件驱动
 * Class Qiniu
 * @package app\admin\logic\driver
 */
class Qiniu extends File
{

    /**
     * 检查文件是否已经存在
     * @param string $name 文件名称
     * @return boolean
     * @throws \think\Exception
     */
    public function has($name)
    {
        return is_array($this->info($name));
    }

    /**
     * 根据Key读取文件内容
     * @param string $name
     * @return string
     * @throws \think\Exception
     */
    public function get($name)
    {
        return file_get_contents($this->getAuth()->privateDownloadUrl($this->base($name)));
    }

    /**
     * 获取文件当前URL地址
     * @param string $name
     * @return boolean|string
     * @throws \think\Exception
     */
    public function url($name)
    {
        return $this->has($name) ? $this->base($name) : false;
    }

    /**
     * 根据配置获取到七牛云文件上传目标地址
     * @param boolean $client
     * @return string
     * @throws \think\Exception
     */
    public function upload($client = true)
    {
        $isHttps = !!self::$config->get('storage_qiniu_is_https');
        switch (self::$config->get('storage_qiniu_region')) {
            case '华东':
                if ($isHttps) return $client ? 'https://upload.qiniup.com' : 'https://upload.qiniup.com';
                return $client ? 'http://upload.qiniup.com' : 'http://upload.qiniup.com';
            case '华北':
                if ($isHttps) return $client ? 'https://upload-z1.qiniup.com' : 'https://up-z1.qiniup.com';
                return $client ? 'http://upload-z1.qiniup.com' : 'http://up-z1.qiniup.com';
            case '北美':
                if ($isHttps) return $client ? 'https://upload-na0.qiniup.com' : 'https://up-na0.qiniup.com';
                return $client ? 'http://upload-na0.qiniup.com' : 'http://up-na0.qiniup.com';
            case '华南':
                if ($isHttps) return $client ? 'https://upload-z2.qiniup.com' : 'https://up-z2.qiniup.com';
                return $client ? 'http://upload-z2.qiniup.com' : 'http://up-z2.qiniup.com';
            default:
                throw new \think\Exception('未配置七牛云存储区域');
        }
    }

    /**
     * 获取七牛云URL前缀
     * @param string $name
     * @return string
     * @throws \think\Exception
     */
    public function base($name = '')
    {
        $domain = self::$config->get('storage_qiniu_domain');
        switch (strtolower(self::$config->get('storage_qiniu_is_https'))) {
            case 'https':
                return "https://{$domain}/{$name}";
            case 'http':
                return "http://{$domain}/{$name}";
            case 'auto':
                return "//{$domain}/{$name}";
        }
        throw new \think\Exception('未设置七牛云文件地址协议');
    }

    /**
     * 七牛云存储
     * @param string $name
     * @param string $content
     * @return array|null
     * @throws \think\Exception
     */
    public function save($name, $content)
    {
        $bucket = self::$config->get('storage_qiniu_bucket');
        $token = $this->getAuth()->uploadToken($bucket);
        list($ret, $err) = (new UploadManager())->put($token, $name, $content);
        if ($err !== null) Log::error(__METHOD__ . " 七牛云文件上传失败，{$err->message()}");
        return $this->info($name);
    }

    /**
     * 获取文件路径
     * @param string $name
     * @return string
     */
    public function path($name)
    {
        return $name;
    }

    /**
     * 获取文件信息
     * @param string $name
     * @return array|null
     * @throws \think\Exception
     */
    public function info($name)
    {
        $manager = new BucketManager($this->getAuth());
        $bucket = self::$config->get('storage_qiniu_bucket');
        list($ret, $err) = $manager->stat($bucket, $name);
        if ($err !== null) return null;
        return ['file' => $name, 'hash' => $ret['hash'], 'url' => $this->base($name), 'key' => $name];
    }

    /**
     * 删除文件
     * @param string $name
     * @return boolean
     */
    public function remove($name)
    {
        $bucket = self::$config->get('storage_qiniu_bucket');
        $err = (new BucketManager($this->getAuth()))->delete($bucket, $name);
        return empty($err);
    }

    /**
     * 获取接口Auth对象
     * @return \Qiniu\Auth
     */
    private function getAuth()
    {
        return new \Qiniu\Auth(
            self::$config->get('storage_qiniu_access_key'),
            self::$config->get('storage_qiniu_secret_key')
        );
    }

}