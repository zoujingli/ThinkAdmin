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

namespace think\admin;

use think\App;
use think\Container;

/**
 * 文件存储引擎管理
 * Class Storage
 * @package think\admin
 * @method array info($name, $safe = false) static 文件存储信息
 * @method array set($name, $file, $safe = false) static 文件储存
 * @method string get($name, $safe = false) static 读取文件内容
 * @method string url($name, $safe = false) static 获取文件链接
 * @method string path($name, $safe = false) static 文件存储路径
 * @method boolean del($name, $safe = false) static 删除存储文件
 * @method boolean has($name, $safe = false) static 检查文件是否存在
 * @method string upload() static 上传目录地址
 */
abstract class Storage
{
    /**
     * 应用实例
     * @var App
     */
    protected $app;

    /**
     * 存储域名前缀
     * @var string
     */
    protected $prefix;

    /**
     * Storage constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * 存储初始化
     * @return Storage
     */
    protected function initialize(): Storage
    {
        return $this;
    }

    /**
     * 静态访问启用
     * @param string $method 方法名称
     * @param array $arguments 调用参数
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function __callStatic($method, $arguments)
    {
        if (method_exists($class = self::instance(), $method)) {
            return call_user_func_array([$class, $method], $arguments);
        } else {
            throw new \think\Exception("method not exists: " . get_class($class) . "->{$method}()");
        }
    }

    /**
     * 设置文件驱动名称
     * @param string $name 驱动名称
     * @return static
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function instance($name = null): Storage
    {
        $class = ucfirst(strtolower(is_null($name) ? sysconf('storage.type') : $name));
        if (class_exists($object = "think\\admin\\storage\\{$class}Storage")) {
            return Container::getInstance()->make($object)->initialize();
        } else {
            throw new \think\Exception("File driver [{$class}] does not exist.");
        }
    }

    /**
     * 获取文件相对名称
     * @param string $url 文件访问链接
     * @param string $ext 文件后缀名称
     * @param string $pre 文件存储前缀
     * @param string $fun 名称规则方法
     * @return string
     */
    public static function name($url, $ext = '', $pre = '', $fun = 'md5'): string
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
            $file = self::instance();
            $name = self::name($url, '', 'down/');
            if (empty($force) && $file->has($name)) {
                if ($expire < 1 || filemtime($file->path($name)) + $expire > time()) {
                    return $file->info($name);
                }
            }
            return $file->set($name, file_get_contents($url));
        } catch (\Exception $e) {
            return ['url' => $url, 'hash' => md5($url), 'key' => $url, 'file' => $url];
        }
    }

    /**
     * 根据文件后缀获取文件MINE
     * @param array|string $exts 文件后缀
     * @param array $mime 文件信息
     * @return string
     */
    public static function mime($exts, $mime = []): string
    {
        $mimes = self::mimes();
        foreach (is_string($exts) ? explode(',', $exts) : $exts as $e) {
            $mime[] = isset($mimes[strtolower($e)]) ? $mimes[strtolower($e)] : 'application/octet-stream';
        }
        return join(',', array_unique($mime));
    }

    /**
     * 获取所有文件的信息
     * @return array
     */
    public static function mimes(): array
    {
        static $mimes = [];
        if (count($mimes) > 0) return $mimes;
        return $mimes = include __DIR__ . '/storage/bin/mimes.php';
    }

}