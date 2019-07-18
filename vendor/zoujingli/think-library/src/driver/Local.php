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

/**
 * 本地文件上传驱动
 * Class Local
 * @package logic\driver
 */
class Local extends File
{

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
     * 根据Key读取文件内容
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
     * 获取文件当前URL地址
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean|string|null
     */
    public function url($name, $safe = false)
    {
        if ($safe) return null;
        return $this->has($name) ? $this->base($name) : false;
    }

    /**
     * 根据配置获取到本地上传的目标地址
     * @return string
     */
    public function upload()
    {
        return url('@') . '?s=admin/api.plugs/upload';
    }

    /**
     * 获取服务器URL前缀
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return string|null
     */
    public function base($name = '', $safe = false)
    {
        if ($safe) return null;
        $root = rtrim(dirname(request()->basefile(true)), '\\/');
        return "{$root}/upload/{$name}";
    }

    /**
     * 获取文件路径
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return string
     */
    public function path($name, $safe = false)
    {
        $path = $safe ? 'safefile' : 'public/upload';
        return str_replace('\\', '/', env('root_path') . "{$path}/{$name}");
    }

    /**
     * 文件储存在本地
     * @param string $name 文件名称
     * @param string $content 文件内容
     * @param boolean $safe 安全模式
     * @return array|null
     */
    public function save($name, $content, $safe = false)
    {
        try {
            $file = $this->path($name, $safe);
            file_exists(dirname($file)) || mkdir(dirname($file), 0755, true);
            if (file_put_contents($file, $content)) return $this->info($name, $safe);
        } catch (\Exception $e) {
            \think\facade\Log::error(__METHOD__ . " 本地文件存储失败，{$e->getMessage()}");
        }
        return null;
    }

    /**
     * 获取文件信息
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return array|null
     */
    public function info($name, $safe = false)
    {
        if ($this->has($name, $safe) && is_string($file = $this->path($name, $safe))) {
            return ['file' => $file, 'hash' => md5_file($file), 'url' => $this->base($name), 'key' => "upload/{$name}"];
        }
        return null;
    }

    /**
     * 删除文件
     * @param string $name 文件名称
     * @param boolean $safe 安全模式
     * @return boolean|null
     */
    public function remove($name, $safe = false)
    {
        if ($this->has($name, $safe) && is_string($file = $this->path($name, $safe))) {
            return @unlink($file);
        }
        return true;
    }

}
