<?php

namespace think\admin\plugs;

use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * Class Plugs
 * @package think\admin\plugs
 */
class Plugs extends Command
{
    /**
     * 目录地址
     * @var string
     */
    protected $uri;

    /**
     * 项目根目录
     * @var string
     */
    protected $root;

    /**
     * 当前版本号
     * @var string
     */
    protected $version;

    /**
     * 指定更新模块
     * @var array
     */
    protected $modules = [];

    public function __construct()
    {
        parent::__construct();
        $this->version = $this->app->config->get('app.thinkadmin_ver');
        if (empty($this->version)) $this->version = 'v4';
        $this->uri = "https://{$this->version}.thinkadmin.top";
        $this->root = strtr(dirname($this->app->getAppPath()) . '/', '\\', '/');
    }

    protected function execute(Input $input, Output $output)
    {
        $data = [];
        $output->comment("=== 准备从代码仓库下载更新{$this->version}版本文件 ===");
        foreach ($this->grenerateDifference() as $file) if (in_array($file['type'], ['add', 'del', 'mod'])) {
            foreach ($this->modules as $module) if (stripos($file['name'], $module) === 0) $data[] = $file;
        }
        if (empty($data)) $output->info('--- 本地文件与线上文件一致，无需更新文件');
        else foreach ($data as $file) $this->fileSynchronization($file);
        $output->comment("=== 从代码仓库下载{$this->version}版本同步更新成功 ===");
        $this->install();
    }

    private function install()
    {
        // #todo 模块安装
    }

    /**
     * 同步指定文件
     * @param array $file
     */
    private function fileSynchronization($file)
    {
        if (in_array($file['type'], ['add', 'mod'])) {
            if ($this->downloadFile(encode($file['name']))) {
                $this->output->writeln("--- 下载 {$file['name']} 更新成功");
            } else {
                $this->output->writeln("--- 下载 {$file['name']} 更新失败");
            }
        } elseif (in_array($file['type'], ['del'])) {
            $real = $this->root . $file['name'];
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
    private function downloadFile($encode)
    {
        $result = json_decode(http_get("{$this->uri}?s=admin/api.update/get/{$encode}"), true);
        if (empty($result['code'])) return false;
        $filename = $this->root . decode($encode);
        file_exists(dirname($filename)) || mkdir(dirname($filename), 0755, true);
        return file_put_contents($filename, base64_decode($result['data']['content']));
    }

    /**
     * 清理空目录
     * @param string $path
     */
    private function removeEmptyDirectory($path)
    {
        if (is_dir($path) && count(scandir($path)) === 2) {
            if (rmdir($path)) $this->removeEmptyDirectory(dirname($path));
        }
    }

    /**
     * 获取文件差异数据
     * @return array
     */
    private function grenerateDifference()
    {
        $result = json_decode(http_get("{$this->uri}?s=/admin/api.update/tree"), true);
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
    public function buildFileList(array $paths, array $ignores = [], array $maps = [])
    {
        foreach ($paths as $key => $dir) {
            $paths[$key] = strtr($dir, '\\', '/');
            $maps = array_merge($maps, $this->getFileList("{$this->root}{$paths[$key]}", $this->root));
        }
        // 清除忽略文件
        foreach ($maps as $key => $map) foreach ($ignores as $ingore) {
            if (stripos($map['name'], $ingore) === 0) unset($maps[$key]);
        }
        return ['paths' => $paths, 'ignores' => $ignores, 'list' => $maps];
    }


    /**
     * 获取目录文件列表
     * @param string $path 待扫描的目录
     * @param array $data 扫描结果
     * @return array
     */
    private function getFileList($path, $data = [])
    {
        if (file_exists($path)) {
            if (is_file($path)) return [$this->getFileInfo($path)];
            if (is_dir($path)) foreach (scandir($path) as $sub) if (strpos($sub, '.') !== 0) {
                if (is_dir($temp = "{$path}/{$sub}")) {
                    $data = array_merge($data, $this->getFileList($temp));
                } else {
                    array_push($data, $this->getFileInfo($temp));
                }
            }
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
            'name' => strtr(strtr(realpath($filename), '\\', '/'), $this->root, ''),
        ];
    }

}