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

namespace think\admin\storage;

use think\admin\extend\HttpExtend;
use think\admin\Storage;

/**
 * 七牛云存储支持
 * Class QiniuStorage
 * @package think\admin\storage
 */
class QiniuStorage extends Storage
{
    private $bucket;
    private $domain;
    private $accessKey;
    private $secretKey;

    /**
     * 存储引擎初始化
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize()
    {
        // 读取配置文件
        $this->bucket = sysconf('storage.qiniu_bucket');
        $this->accessKey = sysconf('storage.qiniu_access_key');
        $this->secretKey = sysconf('storage.qiniu_secret_key');
        $this->domain = strtolower(sysconf('storage.qiniu_http_domain'));
        // 计算链接前缀
        $type = strtolower(sysconf('storage.qiniu_http_protocol'));
        if ($type === 'auto') $this->prefix = "//{$this->domain}/";
        elseif ($type === 'http') $this->prefix = "http://{$this->domain}/";
        elseif ($type === 'https') $this->prefix = "https://{$this->domain}/";
        else throw new \think\Exception('未配置七牛云URL域名哦');
    }

    /**
     * 上传文件内容
     * @param string $name 文件名称
     * @param string $content 文件内容
     * @param boolean $safe 安全模式
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function set($name, $content, $safe = false)
    {
        $token = $this->buildUploadToken($name);
        list($attrs, $frontier) = [[], uniqid()];
        foreach (['key' => $name, 'token' => $token, 'fileName' => $name] as $key => $value) {
            $attrs[] = "--{$frontier}";
            $attrs[] = "Content-Disposition:form-data; name=\"{$key}\"";
            $attrs[] = "";
            $attrs[] = $value;
        }
        $attrs[] = "--{$frontier}";
        $attrs[] = "Content-Disposition:form-data; name=\"file\"; filename=\"{$name}\"";
        $attrs[] = "";
        $attrs[] = $content;
        $attrs[] = "--{$frontier}--";
        return json_decode(HttpExtend::post($this->upload(), join("\r\n", $attrs), [
            'headers' => ["Content-type:multipart/form-data;boundary={$frontier}"],
        ]), true);
    }


    /**
     * 根据文件名读取文件内容
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return string
     */
    public function get($name, $safe = false)
    {
        $url = $this->url($name, $safe) . "?e=" . time();
        $token = "{$this->accessKey}:{$this->safeBase64(hash_hmac('sha1', $url, $this->secretKey, true))}";
        return file_get_contents("{$url}&token={$token}");
    }

    /**
     * 删除存储的文件
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean|null
     */
    public function del($name, $safe = false)
    {
        list($EncodedEntryURI, $AccessToken) = $this->getAccessToken($name, 'delete');
        $data = json_decode(HttpExtend::post("http://rs.qiniu.com/delete/{$EncodedEntryURI}", [], [
            'headers' => ["Authorization:QBox {$AccessToken}"],
        ]), true);
        return empty($data['error']);
    }

    /**
     * 检查文件是否已经存在
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean
     */
    public function has($name, $safe = false)
    {
        return is_array($this->info($name, $safe));
    }

    /**
     * 获取文件当前URL地址
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return string
     */
    public function url($name, $safe = false)
    {
        return "{$this->prefix}/{$name}";
    }

    /**
     * 获取文件存储路径
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return string
     */
    public function path($name, $safe = false)
    {
        return $this->url($name, $safe);
    }

    /**
     * 获取文件存储信息
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return array
     */
    public function info($name, $safe = false)
    {
        list($EncodedEntryURI, $AccessToken) = $this->getAccessToken($name);
        $data = json_decode(HttpExtend::post("http://rs.qiniu.com/stat/{$EncodedEntryURI}", [], [
            'headers' => ["Authorization:QBox {$AccessToken}"],
        ]), true);
        return isset($data['md5']) ? ['file' => $name, 'url' => $this->url($name, $safe), 'hash' => $data['md5'], 'key' => $name] : [];
    }

    /**
     * URL安全的Base64编码
     * @param string $content
     * @return string
     */
    private function safeBase64($content)
    {
        return str_replace(['+', '/'], ['-', '_'], base64_encode($content));
    }

    /**
     * 获取对象管理凭证
     * @param string $name 文件名称
     * @param string $type 操作类型
     * @return array
     */
    private function getAccessToken($name, $type = 'state')
    {
        $EncodedEntryURI = $this->safeBase64("{$this->bucket}:{$name}");
        return [$EncodedEntryURI, "{$this->accessKey}:{$this->safeBase64(hash_hmac('sha1', "/{$type}/{$EncodedEntryURI}\n", $this->secretKey, true))}"];
    }

    /**
     * 获取文件上传地址
     * @return string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function upload()
    {
        $protocol = request()->isSsl() ? 'https' : 'http';
        switch (sysconf('storage.qiniu_region')) {
            case '华东':
                return "{$protocol}://up.qiniup.com";
            case '华北':
                return "{$protocol}://up-z1.qiniup.com";
            case '华南':
                return "{$protocol}://up-z2.qiniup.com";
            case '北美':
                return "{$protocol}://up-na0.qiniup.com";
            case '东南亚':
                return "{$protocol}://up-as0.qiniup.com";
            default:
                throw new \think\Exception('未配置七牛云空间区域哦');
        }
    }

    /**
     * 获取文件上传令牌
     * @param string $name 文件名称
     * @param integer $expires 有效时间
     * @return string
     */
    public function buildUploadToken($name = null, $expires = 3600)
    {
        $policy = $this->safeBase64(json_encode([
            "deadline"   => time() + $expires, "scope" => is_null($name) ? $this->bucket : "{$this->bucket}:{$name}",
            'returnBody' => json_encode(['uploaded' => true, 'filename' => '$(key)', 'url' => "{$this->prefix}/$(key)"], JSON_UNESCAPED_UNICODE),
        ]));
        return "{$this->accessKey}:{$this->safeBase64(hash_hmac('sha1', $policy, $this->secretKey, true))}:{$policy}";
    }
}