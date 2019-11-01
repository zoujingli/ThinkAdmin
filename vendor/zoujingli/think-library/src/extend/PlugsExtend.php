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

namespace think\admin\extend;

use think\App;

/**
 * Class PlugsExtend
 * @package think\admin\extend
 */
class PlugsExtend
{
    /**
     * 当前应用
     * @var App
     */
    private $app;

    /**
     * 目录地址
     * @var string
     */
    protected $uri;

    /**
     * 项目根目录
     * @var string
     */
    protected $path;

    /**
     * 当前版本号
     * @var string
     */
    protected $version;

    /**
     * 指定文件规则
     * @var array
     */
    protected $modules = [];

    /**
     * 当前实例
     * @var $this
     */
    private static $class;

    /**
     * 静态反射对象
     * @param App $app
     * @return $this
     */
    public static function instance(App $app)
    {
        if (empty(self::$class)) {
            self::$class = new static($app);
        }
        return self::$class;
    }

    /**
     * PlugsExtend constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->version = $this->app->config->get('app.thinkadmin_ver');
        if (empty($this->version)) $this->version = 'v4';
        $this->uri = "https://{$this->version}.thinkadmin.top";
        $this->path = strtr($this->app->getRootPath(), '\\', '/');
    }

    /**
     * 获取当前版本
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * 同步指定文件
     * @param array $file
     */
    public function fileSynchronization($file)
    {
        if (in_array($file['type'], ['add', 'mod'])) {
            if ($this->downloadFile(encode($file['name']))) {
                $this->output->writeln("--- 下载 {$file['name']} 更新成功");
            } else {
                $this->output->writeln("--- 下载 {$file['name']} 更新失败");
            }
        } elseif (in_array($file['type'], ['del'])) {
            $real = $this->path . $file['name'];
            if (is_file($real) && unlink($real)) {
                $this->removeEmptyDirectory(dirname($real));
                $this->output->writeln("--- 删除 {$file['name']} 文件成功");
            } else {
                $this->output->error("--- 删除 {$file['name']} 文件失败");
            }
        }
    }


    /**
     * 下载更新文件内容
     * @param string $encode
     * @return boolean|integer
     */
    public function downloadFile($encode)
    {
        $result = json_decode(http_get("{$this->uri}?s=admin/api.update/get/{$encode}"), true);
        if (empty($result['code'])) return false;
        $filename = $this->path . decode($encode);
        file_exists(dirname($filename)) || mkdir(dirname($filename), 0755, true);
        return file_put_contents($filename, base64_decode($result['data']['content']));
    }

    /**
     * 清理空目录
     * @param string $path
     */
    public function removeEmptyDirectory($path)
    {
        if (is_dir($path) && count(scandir($path)) === 2 && rmdir($path)) {
            $this->removeEmptyDirectory(dirname($path));
        }
    }

    /**
     * 获取文件差异数据
     * @return array
     */
    public function grenerateDifference($modules = [])
    {
        $this->modules = $modules;
        $result = json_decode(HttpExtend::get("{$this->uri}?s=/admin/api.update/tree"), true);
        if (empty($result['code'])) return [];
        $new = $this->buildFileList($result['data']['paths'], $result['data']['ignores']);
        return $this->grenerateDifferenceContrast($result['data']['list'], $new['list']);
    }

    /**
     * 两二维数组对比
     * @param array $serve 线上文件列表信息
     * @param array $local 本地文件列表信息
     * @return array
     */
    private function grenerateDifferenceContrast(array $serve = [], array $local = [])
    {
        // 数据扁平化
        list($_serve, $_local, $_new) = [[], [], []];
        foreach ($serve as $t) $_serve[$t['name']] = $t;
        foreach ($local as $t) $_local[$t['name']] = $t;
        unset($serve, $local);
        // 线上数据差异计算
        foreach ($_serve as $t) if (isset($_local[$t['name']])) array_push($_new, [
            'type' => $t['hash'] === $_local[$t['name']]['hash'] ? null : 'mod', 'name' => $t['name'],
        ]);
        else array_push($_new, ['type' => 'add', 'name' => $t['name']]);
        // 本地数据增量计算
        foreach ($_local as $t) if (!isset($_serve[$t['name']])) array_push($_new, ['type' => 'del', 'name' => $t['name']]);
        unset($_serve, $_local);
        usort($_new, function ($a, $b) {
            return $a['name'] !== $b['name'] ? ($a['name'] > $b['name'] ? 1 : -1) : 0;
        });
        return $_new;
    }

    /**
     * 获取文件信息列表
     * @param array $paths 需要扫描的目录
     * @param array $ignores 忽略扫描的文件
     * @param array $maps 扫描结果列表
     * @return array
     */
    public function buildFileList(array $paths, array $ignores = [], array $data = [])
    {
        // 扫描规则文件
        foreach ($paths as $key => $path) {
            $data = array_merge($data, $this->getFileList("{$this->path}{$path}"));
        }
        // 清除忽略文件
        foreach ($data as $key => $map) foreach ($ignores as $ingore) {
            if (stripos($map['name'], $ingore) === 0) unset($data[$key]);
        }
        return ['paths' => $paths, 'ignores' => $ignores, 'list' => $data];
    }

    /**
     * 获取目录文件列表
     * @param string $path 待扫描的目录
     * @param array $data 扫描结果
     * @return array
     */
    private function getFileList($path, $data = [])
    {
        if (file_exists($path)) if (is_dir($path)) foreach (scandir($path) as $sub) {
            if (strpos($sub, '.') !== 0) if (is_dir($temp = "{$path}/{$sub}")) {
                $data = array_merge($data, $this->getFileList($temp));
            } else {
                array_push($data, $this->getFileInfo($temp));
            }
        } else {
            return [$this->getFileInfo($path)];
        }
        return $data;
    }

    /**
     * 获取指定文件信息
     * @param string $filename
     * @return array
     */
    private function getFileInfo($filename)
    {
        return [
            'hash' => md5(preg_replace('/\s+/', '', file_get_contents($filename))),
            'name' => strtr(strtr(realpath($filename), '\\', '/'), $this->path, ''),
        ];
    }
}