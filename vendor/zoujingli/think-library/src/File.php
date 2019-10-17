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

namespace library;

use library\driver\Local;
use library\driver\Oss;
use library\driver\Qiniu;
use library\tools\Options;
use think\Exception;
use think\facade\Log;

/**
 * 文件管理逻辑
 * Class File
 * @package library
 * @method bool has($name, $safe = false) static 判断文件是否已经上传
 * @method array save($name, $content, $safe = false) static 保存二进制文件
 * @method array info($name, $safe = false) static 获取文件信息
 * @method string url($name, $safe = false) static 获取文件URL地址
 * @method string get($name, $safe = false) static 获取文件二进制内容
 * @method string base($name, $safe = false) static 获取文件存储根目录
 * @method string path($name, $safe = false) static 获取文件存储物理路径
 * @method string remove($name, $safe = false) static 删除已经上传的文件
 * @method string upload($client = false) static 获取文件上传目标地址
 * @method string setBucket($name) static 阿里云OSS专属创建Bucket空间
 */
class File
{
    const DEVER_LOCAL = 'local';
    const DERVER_QINIU = 'qiniu';
    const DERVER_ALIOSS = 'oss';

    /**
     * 当前配置对象
     * @var Options
     */
    public static $config;

    /**
     * 对象缓存器
     * @var array
     */
    protected static $object = [];

    /**
     * 文件存储参数
     * @var array
     */
    protected static $params = [
        'const' => [
            'storage_type' => '文件存储类型',
        ],
        'local' => [
            'storage_local_exts' => '文件上传允许类型后缀',
        ],
        'oss'   => [
            'storage_oss_domain'   => '文件访问域名',
            'storage_oss_keyid'    => '接口授权AppId',
            'storage_oss_secret'   => '接口授权AppSecret',
            'storage_oss_bucket'   => '文件存储空间名称',
            'storage_oss_is_https' => '文件HTTP访问协议',
            'storage_oss_endpoint' => '文件存储节点域名',
        ],
        'qiniu' => [
            'storage_qiniu_region'     => '文件存储节点',
            'storage_qiniu_domain'     => '文件访问域名',
            'storage_qiniu_bucket'     => '文件存储空间名称',
            'storage_qiniu_is_https'   => '文件HTTP访问协议',
            'storage_qiniu_access_key' => '接口授权AccessKey',
            'storage_qiniu_secret_key' => '接口授权SecretKey',
        ],
    ];

    /**
     * 静态魔术方法
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if (method_exists($class = self::instance(self::$config->get('storage_type')), $name)) {
            return call_user_func_array([$class, $name], $arguments);
        }
        throw new Exception("File driver method not exists: " . get_class($class) . "->{$name}");
    }

    /**
     * 设置文件驱动名称
     * @param string $name
     * @return Local|Qiniu|Oss
     * @throws Exception
     */
    public static function instance($name)
    {
        if (isset(self::$object[$class = ucfirst(strtolower($name))])) {
            return self::$object[$class];
        }
        if (class_exists($object = __NAMESPACE__ . "\\driver\\{$class}")) {
            return self::$object[$class] = new $object;
        }
        throw new Exception("File driver [{$class}] does not exist.");
    }
    
    /**
     * 根据文件后缀获取文件MINE
     * @param array $ext 文件后缀
     * @param array $mine 文件后缀MINE信息
     * @return string
     */
    public static function mine($ext, $mine = [])
    {
        $mines = self::mines();
        foreach (is_string($ext) ? explode(',', $ext) : $ext as $e) {
            $mine[] = isset($mines[strtolower($e)]) ? $mines[strtolower($e)] : 'application/octet-stream';
        }
        return join(',', array_unique($mine));
    }

    /**
     * 获取所有文件扩展的mine
     * @return mixed
     */
    public static function mines()
    {
        $mines = cache('all_ext_mine');
        if (empty($mines)) {
            $content = file_get_contents('http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types');
            preg_match_all('#^([^\s]{2,}?)\s+(.+?)$#ism', $content, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) foreach (explode(" ", $match[2]) as $ext) $mines[$ext] = $match[1];
            cache('all_ext_mine', $mines);
        }
        return $mines;
    }


    /**
     * 获取文件相对名称
     * @param string $url 文件链接
     * @param string $ext 文件后缀
     * @param string $pre 文件前缀（若有值需要以/结尾）
     * @param string $fun 文件名生成方法
     * @return string
     */
    public static function name($url, $ext = '', $pre = '', $fun = 'md5')
    {
        empty($ext) && $ext = pathinfo($url, 4);
        empty($ext) || $ext = trim($ext, '.\\/');
        empty($pre) || $pre = trim($pre, '.\\/');
        $splits = array_merge([$pre], str_split($fun($url), 16));
        return trim(join('/', $splits), '/') . '.' . strtolower($ext ? $ext : 'tmp');
    }

    /**
     * 下载文件到本地
     * @param string $url 文件URL地址
     * @param boolean $force 是否强制下载
     * @param integer $expire 文件保留时间
     * @return array
     */
    public static function down($url, $force = false, $expire = 0)
    {
        try {
            $file = self::instance('local');
            $name = self::name($url, '', 'down/');
            if (empty($force) && $file->has($name)) {
                if ($expire < 1 || filemtime($file->path($name)) + $expire > time()) {
                    return $file->info($name);
                }
            }
            return $file->save($name, file_get_contents($url));
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " File download failed [ {$url} ] {$e->getMessage()}");
            return ['url' => $url, 'hash' => md5($url), 'key' => $url, 'file' => $url];
        }
    }

    /**
     * 文件储存初始化
     * @param array $data
     * @throws Exception
     * @throws \think\exception\PDOException
     */
    public static function init($data = [])
    {
        if (empty(self::$config) && function_exists('sysconf')) {
            foreach (self::$params as $arr) {
                foreach (array_keys($arr) as $key) {
                    $data[$key] = sysconf($key);
                }
            }
        }
        self::$config = new Options($data);
    }
}


try {
    // 初始化存储
    File::init();
    // Log::info(__METHOD__ . ' File storage initialization success');
} catch (\Exception $e) {
    Log::error(__METHOD__ . " File storage initialization exception. [{$e->getMessage()}]");
}
