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
use OSS\Model\CorsConfig;
use OSS\Model\CorsRule;
use OSS\OssClient;

/**
 * AliOss文件存储
 * Class Oss
 * @package logic\driver
 */
class Oss extends File
{

    /**
     * 检查文件是否已经存在
     * @param string $name
     * @return boolean
     * @throws \OSS\Core\OssException
     */
    public function has($name)
    {
        $bucket = self::$config->get('storage_oss_bucket');
        return $this->getOssClient()->doesObjectExist($bucket, $name);
    }

    /**
     * 根据Key读取文件内容
     * @param string $name
     * @return string
     * @throws \OSS\Core\OssException
     */
    public function get($name)
    {
        $bucket = self::$config->get('storage_oss_bucket');
        return $this->getOssClient()->getObject($bucket, $name);
    }

    /**
     * 获取文件当前URL地址
     * @param string $name 文件HASH名称
     * @return boolean|string
     * @throws \OSS\Core\OssException
     * @throws \think\Exception
     */
    public function url($name)
    {
        return $this->has($name) ? $this->base($name) : false;
    }

    /**
     * 获取AliOSS上传地址
     * @return string
     */
    public function upload()
    {
        $protocol = request()->isSsl() ? 'https' : 'http';
        return "{$protocol}://" . self::$config->get('storage_oss_domain');
    }

    /**
     * 获取阿里云对象存储URL前缀
     * @param string $name
     * @return string
     * @throws \think\Exception
     */
    public function base($name = '')
    {
        $domain = self::$config->get('storage_oss_domain');
        switch (strtolower(self::$config->get('storage_oss_is_https'))) {
            case 'https':
                return "https://{$domain}/{$name}";
            case 'http':
                return "http://{$domain}/{$name}";
            case 'auto':
                return "//{$domain}/{$name}";
        }
        throw new \think\Exception('未设置阿里云文件地址协议');
    }

    /**
     * 阿里云OSS
     * @param string $name
     * @param string $content
     * @return array|null
     */
    public function save($name, $content)
    {
        try {
            $bucket = self::$config->get('storage_oss_bucket');
            $result = $this->getOssClient()->putObject($bucket, $name, $content);
            return ['file' => $name, 'hash' => $result['content-md5'], 'key' => $name, 'url' => $this->base($name)];
        } catch (\Exception $e) {
            \think\facade\Log::error("阿里云OSS文件上传失败，{$e->getMessage()}");
            return null;
        }
    }

    /**
     * 创建OSS空间名称
     * @param string $bucket OSS空间名称
     * @return string 返回新创建的域名
     * @throws \OSS\Core\OssException
     */
    public function setBucket($bucket)
    {
        $client = $this->getOssClient();
        // 空间及权限处理
        $aclType = OssClient::OSS_ACL_TYPE_PUBLIC_READ_WRITE;
        if ($client->doesBucketExist($bucket)) {
            $result = $client->getBucketMeta($bucket);
            if ($client->getBucketAcl($bucket) !== $aclType) {
                $client->putBucketAcl($bucket, $aclType);
            }
        } else {
            $result = $client->createBucket($bucket, $aclType);
        }
        // CORS 跨域处理
        $corsRule = new CorsRule();
        $corsRule->addAllowedHeader('*');
        $corsRule->addAllowedOrigin('*');
        $corsRule->addAllowedMethod('GET');
        $corsRule->addAllowedMethod('POST');
        $corsRule->setMaxAgeSeconds(36000);
        $corsConfig = new CorsConfig();
        $corsConfig->addRule($corsRule);
        $client->putBucketCors($bucket, $corsConfig);
        return pathinfo($result['oss-request-url'], PATHINFO_BASENAME);
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
     * @throws \OSS\Core\OssException
     * @throws \think\Exception
     */
    public function info($name)
    {
        $bucket = self::$config->get('storage_oss_bucket');
        $result = $this->getOssClient()->getObjectMeta($bucket, $name);
        if (empty($result) || !isset($result['content-md5'])) return null;
        return ['file' => $name, 'hash' => $result['content-md5'], 'url' => $this->base($name), 'key' => $name];
    }

    /**
     * 删除文件
     * @param string $name
     * @return boolean
     * @throws \Exception
     */
    public function remove($name)
    {
        try {
            $bucket = self::$config->get('storage_oss_bucket');
            $this->getOssClient()->deleteObject($bucket, $name);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 获取OssClient对象
     * @return OssClient
     * @throws \OSS\Core\OssException
     */
    private function getOssClient()
    {
        $keyid = self::$config->get('storage_oss_keyid');
        $secret = self::$config->get('storage_oss_secret');
        $endpoint = 'http://' . self::$config->get('storage_oss_endpoint');
        return new OssClient($keyid, $secret, $endpoint);
    }

}