<?php

declare (strict_types=1);

namespace think\admin\storage;

use think\admin\Exception;
use think\admin\extend\HttpExtend;
use think\admin\Storage;

/**
 * 腾讯云COS存储支持
 * Class TxcosStorage
 * @package think\admin\storage
 */
class TxcosStorage extends Storage
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
     * $secretId
     * @var string
     */
    private $secretId;

    /**
     * secretKey
     * @var string
     */
    private $secretKey;

    /**
     * 初始化入口
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize()
    {
        // 读取配置文件
        $this->point = sysconf('storage.txcos_point');
        $this->bucket = sysconf('storage.txcos_bucket');
        $this->secretId = sysconf('storage.txcos_access_key');
        $this->secretKey = sysconf('storage.txcos_secret_key');
        // 计算链接前缀
        $type = strtolower(sysconf('storage.txcos_http_protocol'));
        $domain = strtolower(sysconf('storage.txcos_http_domain'));
        if ($type === 'auto') {
            $this->prefix = "//{$domain}";
        } elseif (in_array($type, ['http', 'https'])) {
            $this->prefix = "{$type}://{$domain}";
        } else throw new Exception('未配置腾讯云COS访问域名哦');
    }

    /**
     * 获取当前实例对象
     * @param null|string $name
     * @return TxcosStorage
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function instance(?string $name = null)
    {
        return parent::instance('txcos');
    }

    /**
     * 上传文件内容
     * @param string $name 文件名称
     * @param string $file 文件内容
     * @param boolean $safe 安全模式
     * @param null|string $attname 下载名称
     * @return array
     */
    public function set(string $name, string $file, bool $safe = false, ?string $attname = null): array
    {
        $data = $this->buildUploadToken($name) + ['key' => $name];
        if (is_string($attname) && strlen($attname) > 0) {
            $data['Content-Disposition'] = urlencode($attname);
        }
        $data['success_action_status'] = '200';
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
     * @return string
     */
    public function get(string $name, bool $safe = false): string
    {
        return static::curlGet($this->url($name, $safe));
    }

    /**
     * 删除存储的文件
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean
     */
    public function del(string $name, bool $safe = false): bool
    {
        [$file] = explode('?', $name);
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
    public function has(string $name, bool $safe = false): bool
    {
        $file = $this->delSuffix($name);
        $result = HttpExtend::request('HEAD', "http://{$this->bucket}.{$this->point}/{$file}", [
            'returnHeader' => true, 'headers' => $this->headerSign('HEAD', $name),
        ]);
        return is_numeric(stripos($result, 'HTTP/1.1 200 OK'));
    }

    /**
     * 获取文件当前URL地址
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @param null|string $attname 下载名称
     * @return string
     */
    public function url(string $name, bool $safe = false, ?string $attname = null): string
    {
        return "{$this->prefix}/{$this->delSuffix($name)}{$this->getSuffix($attname,$name)}";
    }

    /**
     * 获取文件存储路径
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return string
     */
    public function path(string $name, bool $safe = false): string
    {
        return $this->url($name, $safe);
    }

    /**
     * 获取文件存储信息
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @param null|string $attname 下载名称
     * @return array
     */
    public function info(string $name, bool $safe = false, ?string $attname = null): array
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
    public function upload(): string
    {
        $protocol = $this->app->request->isSsl() ? 'https' : 'http';
        return "{$protocol}://{$this->bucket}.{$this->point}";
    }

    /**
     * 获取文件上传令牌
     * @param string $name 文件名称
     * @param integer $expires 有效时间
     * @param null|string $attname 下载名称
     * @return array
     */
    public function buildUploadToken(string $name, int $expires = 3600, ?string $attname = null): array
    {
        $startTimestamp = time();
        $endTimestamp = $startTimestamp + $expires;
        $keyTime = "{$startTimestamp};{$endTimestamp}";
        $siteurl = $this->url($name, false, $attname);
        $policy = json_encode([
            'expiration' => date('Y-m-d\TH:i:s.000\Z', $endTimestamp),
            'conditions' => [['q-ak' => $this->secretId], ['q-sign-time' => $keyTime], ['q-sign-algorithm' => 'sha1']],
        ]);
        return [
            'policy'      => base64_encode($policy), 'q-ak' => $this->secretId,
            'siteurl'     => $siteurl, 'q-key-time' => $keyTime, 'q-sign-algorithm' => 'sha1',
            'q-signature' => hash_hmac('sha1', sha1($policy), hash_hmac('sha1', $keyTime, $this->secretKey)),
        ];
    }

    /**
     * 操作请求头信息签名
     * @param string $method 请求方式
     * @param string $soruce 资源名称
     * @return array
     */
    private function headerSign(string $method, string $soruce): array
    {
        $header = [];
        // 1.生成 KeyTime
        $startTimestamp = time();
        $endTimestamp = $startTimestamp + 3600;
        $keyTime = "{$startTimestamp};{$endTimestamp}";
        // 2.生成 SignKey
        $signKey = hash_hmac('sha1', $keyTime, $this->secretKey);
        // 3.生成 UrlParamList, HttpParameters
        [$parse_url, $urlParamList, $httpParameters] = [parse_url($soruce), '', ''];
        if (!empty($parse_url['query'])) {
            parse_str($parse_url['query'], $params);
            uksort($params, 'strnatcasecmp');
            $urlParamList = join(';', array_keys($params));
            $httpParameters = http_build_query($params);
        }
        // 4.生成 HeaderList, HttpHeaders
        [$headerList, $httpHeaders] = ['', ''];
        if (!empty($header)) {
            uksort($header, 'strnatcasecmp');
            $headerList = join(';', array_keys($header));
            $httpHeaders = http_build_query($header);
        }
        // 5.生成 HttpString
        $httpString = strtolower($method) . "\n/{$parse_url['path']}\n{$httpParameters}\n{$httpHeaders}\n";
        // 6.生成 StringToSign
        $httpStringSha1 = sha1($httpString);
        $stringToSign = "sha1\n{$keyTime}\n{$httpStringSha1}\n";
        // 7.生成 Signature
        $signature = hash_hmac('sha1', $stringToSign, $signKey);
        // 8.生成签名
        $signArray = [
            'q-sign-algorithm' => 'sha1',
            'q-ak'             => $this->secretId,
            'q-sign-time'      => $keyTime,
            'q-key-time'       => $keyTime,
            'q-header-list'    => $headerList,
            'q-url-param-list' => $urlParamList,
            'q-signature'      => $signature,
        ];
        $header['Authorization'] = urldecode(http_build_query($signArray));
        foreach ($header as $key => $value) $header[$key] = ucfirst($key) . ": {$value}";
        return array_values($header);
    }

    /**
     * 腾讯云COS存储区域
     * @return array
     */
    public static function region(): array
    {
        return [
            'cos.ap-beijing-1.myqcloud.com'     => '中国大陆 公有云地域 北京一区',
            'cos.ap-beijing.myqcloud.com'       => '中国大陆 公有云地域 北京',
            'cos.ap-nanjing.myqcloud.com'       => '中国大陆 公有云地域 南京',
            'cos.ap-shanghai.myqcloud.com'      => '中国大陆 公有云地域 上海',
            'cos.ap-guangzhou.myqcloud.com'     => '中国大陆 公有云地域 广州',
            'cos.ap-chengdu.myqcloud.com'       => '中国大陆 公有云地域 成都',
            'cos.ap-chongqing.myqcloud.com'     => '中国大陆 公有云地域 重庆',
            'cos.ap-shenzhen-fsi.myqcloud.com'  => '中国大陆 金融云地域 深圳金融',
            'cos.ap-shanghai-fsi.myqcloud.com'  => '中国大陆 金融云地域 上海金融',
            'cos.ap-beijing-fsi.myqcloud.com'   => '中国大陆 金融云地域 北京金融',
            'cos.ap-hongkong.myqcloud.com'      => '亚太地区 公有云地域 中国香港',
            'cos.ap-singapore.myqcloud.com'     => '亚太地区 公有云地域 新加坡',
            'cos.ap-mumbai.myqcloud.com'        => '亚太地区 公有云地域 孟买',
            'cos.ap-seoul.myqcloud.com'         => '亚太地区 公有云地域 首尔',
            'cos.ap-bangkok.myqcloud.com'       => '亚太地区 公有云地域 曼谷',
            'cos.ap-tokyo.myqcloud.com'         => '亚太地区 公有云地域 东京',
            'cos.na-siliconvalley.myqcloud.com' => '北美地区 公有云地域 硅谷',
            'cos.na-ashburn.myqcloud.com'       => '北美地区 公有云地域 弗吉尼亚',
            'cos.na-toronto.myqcloud.com'       => '北美地区 公有云地域 多伦多',
            'cos.eu-frankfurt.myqcloud.com'     => '欧洲地区 公有云地域 法兰克福',
            'cos.eu-moscow.myqcloud.com'        => '欧洲地区 公有云地域 莫斯科	',
        ];
    }

}