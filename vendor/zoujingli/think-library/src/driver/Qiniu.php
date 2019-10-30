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

namespace library\driver;

use library\File;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use think\facade\Log;
use think\facade\Request;

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
     * @param string $name 文件名称
     * @return string
     * @throws \think\Exception
     */
    public function get($name)
    {
        return file_get_contents($this->getAuth()->privateDownloadUrl($this->base($name)));
    }

    /**
     * 获取文件当前URL地址
     * @param string $name 文件名称
     * @return boolean|string|null
     * @throws \think\Exception
     */
    public function url($name)
    {
        return $this->has($name) ? $this->base($name) : false;
    }

    /**
     * 根据请求计算七牛云文件上传目标地址
     * @param boolean $client
     * @return string
     * @throws \think\Exception
     */
    public function upload($client = false)
    {
        $protocol = Request::isSsl() ? 'https' : 'http';
        switch (self::$config->get('storage_qiniu_region')) {
            case '华东':
                return $client ? "{$protocol}://up.qiniup.com" : "{$protocol}://upload.qiniup.com";
            case '华北':
                return $client ? "{$protocol}://up-z1.qiniup.com" : "{$protocol}://upload-z1.qiniup.com";
            case '北美':
                return $client ? "{$protocol}://up-na0.qiniup.com" : "{$protocol}://upload-na0.qiniup.com";
            case '华南':
                return $client ? "{$protocol}://up-z2.qiniup.com" : "{$protocol}://upload-z2.qiniup.com";
            case "东南亚":
                return $client ? "{$protocol}://up-as0.qiniup.com" : "{$protocol}://upload-as0.qiniup.com";
            default:
                throw new \think\Exception('未配置七牛云存储区域');
        }
    }

    /**
     * 获取七牛云URL前缀
     * @param string $name 文件名称
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
            default:
                throw new \think\Exception('未配置七牛云URL前缀');
        }
    }

    /**
     * 七牛云存储文件
     * @param string $name 文件名称
     * @param string $content 文件内容
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
     * @param string $name 文件名称
     * @return string
     */
    public function path($name)
    {
        return $name;
    }

    /**
     * 获取文件信息
     * @param string $name 文件名称
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
     * @param string $name 文件名称
     * @return boolean
     */
    public function remove($name)
    {
        $bucket = self::$config->get('storage_qiniu_bucket');
        $err = (new BucketManager($this->getAuth()))->delete($bucket, $name);
        return empty($err);
    }

    /**
     * 获取空间列表
     * @return string
     * @throws \Exception
     */
    public function getBucketList()
    {
        list($list, $err) = (new BucketManager($this->getAuth()))->buckets(true);
        if (!empty($err)) throw new \Exception($err);
        foreach ($list as &$bucket) {
            list($domain, $err) = $this->getDomainList($bucket);
            if (empty($err)) {
                $bucket = ['bucket' => $bucket, 'domain' => $domain];
            } else {
                throw new \Exception($err);
            }
        }
        return $list;
    }

    /**
     * 获取空间绑定的域名列表
     * @param string $bucket 空间名称
     * @return array
     */
    public function getDomainList($bucket)
    {
        return (new BucketManager($this->getAuth()))->domains($bucket);
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

    /**
     * 生成文件上传TOKEN
     * @param null|string $key 指定保存名称
     * @param integer $expires 指定令牌有效时间
     * @return string
     * @throws \think\Exception
     */
    public function buildUploadToken($key = null, $expires = 3600)
    {
        $location = $this->base();
        $bucket = self::$config->get('storage_qiniu_bucket');
        $policy = ['returnBody' => '{"uploaded":true,"filename":"$(key)","url":"' . $location . '$(key)"}'];
        return $this->getAuth()->uploadToken($bucket, $key, $expires, $policy, true);
    }

}
