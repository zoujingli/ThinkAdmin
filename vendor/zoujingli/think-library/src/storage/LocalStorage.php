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

use think\admin\Storage;

/**
 * 本地存储支持
 * Class LocalStorage
 * @package think\admin\storage
 */
class LocalStorage extends Storage
{

    /**
     * 初始化入口
     * @return Storage
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize()
    {
        // 计算链接前缀
        $type = strtolower(sysconf('storage.local_http_protocol'));
        if ($type === 'path') {
            $file = $this->app->request->baseFile(false);
            $this->prefix = trim(dirname($file), '\\/');
        } else {
            $this->prefix = dirname($this->app->request->basefile(true));
            list(, $domain) = explode('://', strtr($this->prefix, '\\', '/'));
            if ($type === 'auto') $this->prefix = "//{$domain}";
            elseif ($type === 'http') $this->prefix = "http://{$domain}";
            elseif ($type === 'https') $this->prefix = "https://{$domain}";
        }
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
        return parent::instance('local');
    }

    /**
     * 文件储存在本地
     * @param string $name 文件名称
     * @param string $file 文件内容
     * @param boolean $safe 安全模式
     * @param string $attname 下载名称
     * @return array
     */
    public function set($name, $file, $safe = false, $attname = null)
    {
        try {
            $path = $this->path($name, $safe);
            file_exists(dirname($path)) || mkdir(dirname($path), 0755, true);
            if (file_put_contents($path, $file)) {
                return $this->info($name, $safe, $attname);
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * 根据文件名读取文件内容
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return string
     */
    public function get($name, $safe = false)
    {
        if (!$this->has($name, $safe)) return '';
        return file_get_contents($this->path($name, $safe));
    }

    /**
     * 删除存储的文件
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean
     */
    public function del($name, $safe = false)
    {
        if ($this->has($name, $safe)) {
            return @unlink($this->path($name, $safe));
        } else {
            return false;
        }
    }

    /**
     * 检查文件是否已经存在
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean
     */
    public function has($name, $safe = false)
    {
        return file_exists($this->path($name, $safe));
    }

    /**
     * 获取文件当前URL地址
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @param string $attname 下载名称
     * @return string|null
     */
    public function url($name, $safe = false, $attname = null)
    {
        return $safe ? $name : "{$this->prefix}/upload/{$this->delSuffix($name)}{$this->getSuffix($attname)}";
    }

    /**
     * 获取文件存储路径
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return string
     */
    public function path($name, $safe = false)
    {
        $root = $this->app->getRootPath();
        $path = $safe ? 'safefile' : 'public/upload';
        return strtr("{$root}{$path}/{$this->delSuffix($name)}", '\\', '/');
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
            'key' => "upload/{$name}", 'file' => $this->path($name, $safe),
        ] : [];
    }

    /**
     * 获取文件上传地址
     * @return string
     */
    public function upload()
    {
        return url('admin/api.upload/file')->build();
    }

}