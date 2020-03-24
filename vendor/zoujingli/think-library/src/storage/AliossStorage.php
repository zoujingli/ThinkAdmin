<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
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
 * 阿里云OSS存储支持
 * Class AliossStorage
 * @package think\admin\storage
 */
class AliossStorage extends Storage
{
    /**
     * 数据中心
     * @var string
     */
    private $point;

    /**
     * 存储空间名称
     * @var string
     */
    private $bucket;

    /**
     * 绑定访问域名
     * @var string
     */
    private $domain;

    /**
     * AccessKeyId
     * @var string
     */
    private $accessKey;

    /**
     * AccessKeySecret
     * @var string
     */
    private $secretKey;

    /**
     * 初始化入口
     * @return Storage
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize()
    {
        // 读取配置文件
        $this->point = sysconf('storage.alioss_point');
        $this->bucket = sysconf('storage.alioss_bucket');
        $this->domain = sysconf('storage.alioss_http_domain');
        $this->accessKey = sysconf('storage.alioss_access_key');
        $this->secretKey = sysconf('storage.alioss_secret_key');
        // 计算链接前缀
        $type = strtolower(sysconf('storage.alioss_http_protocol'));
        if ($type === 'auto') $this->prefix = "//{$this->domain}";
        elseif ($type === 'http') $this->prefix = "http://{$this->domain}";
        elseif ($type === 'https') $this->prefix = "https://{$this->domain}";
        else throw new \think\admin\Exception('未配置阿里云URL域名哦');
        // 初始化配置并返回当前实例
        return parent::initialize();
    }

    /**
     * 获取当前实例对象
     * @param null $name
     * @return AliossStorage|LocalStorage|QiniuStorage
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function instance($name = null)
    {
        return parent::instance('alioss');
    }

    /**
     * 上传文件内容
     * @param string $name 文件名称
     * @param string $file 文件内容
     * @param boolean $safe 安全模式
     * @param string $attname 下载名称
     * @return array
     */
    public function set($name, $file, $safe = false, $attname = null)
    {
        $token = $this->buildUploadToken($name);
        $data = ['key' => $name];
        $data['policy'] = $token['policy'];
        $data['Signature'] = $token['signature'];
        $data['OSSAccessKeyId'] = $this->accessKey;
        $data['success_action_status'] = '200';
        if (is_string($attname) && strlen($attname) > 0) {
            $filename = urlencode($attname);
            $data['Content-Disposition'] = "inline;filename={$filename}";
        }
        $file = ['field' => 'file', 'name' => $name, 'content' => $file];
        if (is_numeric(stripos(HttpExtend::submit($this->upload(), $data, $file), '200 OK'))) {
            return ['file' => $this->path($name, $safe), 'url' => $this->url($name, $safe, $attname), 'key' => $name];
        } else {
            return [];
        }
    }

    /**
     * 根据文件名读取文件内容
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return false|string
     */
    public function get($name, $safe = false)
    {
        return file_get_contents($this->url($name, $safe));
    }

    /**
     * 删除存储的文件
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean
     */
    public function del($name, $safe = false)
    {
        list($file) = explode('?', $name);
        $result = HttpExtend::request('DELETE', "http://{$this->bucket}.{$this->point}/{$file}", [
            'returnHeader' => true, 'headers' => $this->headerSign('DELETE', $file),
        ]);
        return is_numeric(stripos($result, '204 No Content'));
    }

    /**
     * 判断文件是否存在
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean
     */
    public function has($name, $safe = false)
    {
        $file = $this->delSuffix($name);
        $result = HttpExtend::request('HEAD', "http://{$this->bucket}.{$this->point}/{$file}", [
            'returnHeader' => true, 'headers' => $this->headerSign('HEAD', $file),
        ]);
        return is_numeric(stripos($result, 'HTTP/1.1 200 OK'));
    }

    /**
     * 获取文件当前URL地址
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @param string $attname 下载名称
     * @return string
     */
    public function url($name, $safe = false, $attname = null)
    {
        return "{$this->prefix}/{$this->delSuffix($name)}{$this->getSuffix($attname)}";
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
     * @param string $attname 下载名称
     * @return array
     */
    public function info($name, $safe = false, $attname = null)
    {
        return $this->has($name, $safe) ? [
            'url' => $this->url($name, $safe, $attname),
            'key' => $name, 'file' => $this->path($name, $safe),
        ] : [];
    }

    /**
     * 获取文件上传地址
     * @return string
     */
    public function upload()
    {
        $http = $this->app->request->isSsl() ? 'https' : 'http';
        return "{$http}://{$this->bucket}.{$this->point}";
    }

    /**
     * 获取文件上传令牌
     * @param string $name 文件名称
     * @param integer $expires 有效时间
     * @param string $attname 下载名称
     * @return array
     */
    public function buildUploadToken($name = null, $expires = 3600, $attname = null)
    {
        $data = [
            'policy'  => base64_encode(json_encode([
                'conditions' => [['content-length-range', 0, 1048576000]],
                'expiration' => date('Y-m-d\TH:i:s.000\Z', time() + $expires),
            ])),
            'siteurl' => $this->url($name, false, $attname),
            'keyid'   => $this->accessKey,
        ];
        $data['signature'] = base64_encode(hash_hmac('sha1', $data['policy'], $this->secretKey, true));
        return $data;
    }

    /**
     * 操作请求头信息签名
     * @param string $method 请求方式
     * @param string $soruce 资源名称
     * @param array $header 请求头信息
     * @return array
     */
    private function headerSign($method, $soruce, $header = [])
    {
        if (empty($header['Date'])) $header['Date'] = gmdate('D, d M Y H:i:s \G\M\T');
        if (empty($header['Content-Type'])) $header['Content-Type'] = 'application/xml';
        uksort($header, 'strnatcasecmp');
        $content = "{$method}\n\n";
        foreach ($header as $key => $value) {
            $value = str_replace(["\r", "\n"], '', $value);
            if (in_array(strtolower($key), ['content-md5', 'content-type', 'date'])) {
                $content .= "{$value}\n";
            } elseif (stripos($key, 'x-oss-') === 0) {
                $content .= strtolower($key) . ":{$value}\n";
            }
        }
        $content = rawurldecode($content) . "/{$this->bucket}/{$soruce}";
        $signature = base64_encode(hash_hmac('sha1', $content, $this->secretKey, true));
        $header['Authorization'] = "OSS {$this->accessKey}:{$signature}";
        foreach ($header as $key => $value) $header[$key] = "{$key}: {$value}";
        return array_values($header);
    }

}