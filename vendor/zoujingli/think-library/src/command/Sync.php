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

namespace library\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 文件比对同步支持
 * Class Sync
 * @package library\command
 */
class Sync extends Command
{
    /**
     * 基础URL地址
     * @var string
     */
    protected $uri;

    /**
     * 当前Admin版本号
     * @var string
     */
    protected $version;

    /**
     * 指定更新模块
     * @var array
     */
    protected $modules = [];

    /**
     * Sync constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        $this->version = config('app.thinkadmin_ver');
        if (empty($this->version)) $this->version = 'v4';
        $this->uri = "https://{$this->version}.thinkadmin.top";
        parent::__construct($name);
    }

    /**
     * 执行更新操作
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $files = [];
        $output->comment("=== 准备从代码仓库下载更新{$this->version}版本文件 ===");
        foreach ($this->getDiff() as $file) if (in_array($file['type'], ['add', 'del', 'mod'])) {
            foreach ($this->modules as $module) if (stripos($file['name'], $module) === 0) $files[] = $file;
        }
        if (empty($files)) $output->info('--- 本地文件与线上文件一致，无需更新文件');
        else foreach ($files as $file) $this->syncFile($file, $output);
        $output->comment("=== 从代码仓库下载{$this->version}版本同步更新成功 ===");
    }

    /**
     * 获取当前系统文件列表
     * @return array
     */
    public function build()
    {
        return $this->tree([
            'think', 'config/log.php', 'config/cookie.php', 'config/template.php',
            'application/admin', 'application/wechat', 'application/service',
            'public/static/plugs', 'public/static/theme', 'public/static/admin.js',
        ]);
    }

    /**
     * 获取文件信息列表
     * @param array $paths 需要扫描的目录
     * @param array $ignores 忽略扫描的文件
     * @param array $maps 扫描结果列表
     * @return array
     */
    public function tree(array $paths, array $ignores = [], array $maps = [])
    {
        $root = str_replace('\\', '/', env('root_path'));
        foreach ($paths as $key => $dir) {
            $paths[$key] = str_replace('\\', '/', $dir);
            $maps = array_merge($maps, $this->scanDir("{$root}{$paths[$key]}", $root));
        }
        // 清除忽略文件
        foreach ($maps as $key => $map) foreach ($ignores as $ingore) {
            if (stripos($map['name'], $ingore) === 0) unset($maps[$key]);
        }
        return ['paths' => $paths, 'ignores' => $ignores, 'list' => $maps];
    }

    /**
     * 同步所有差异文件
     */
    public function sync()
    {
        foreach ($this->getDiff() as $file) {
            $this->syncFile($file, new Output());
        }
    }

    /**
     * 同步指定文件
     * @param array $file
     * @param Output $output
     */
    private function syncFile($file, $output)
    {
        if (in_array($file['type'], ['add', 'mod'])) {
            if ($this->runDown(encode($file['name']))) {
                $output->writeln("--- 下载 {$file['name']} 更新成功");
            } else {
                $output->error("--- 下载 {$file['name']} 更新失败");
            }
        } elseif (in_array($file['type'], ['del'])) {
            $real = realpath(env('root_path') . $file['name']);
            if (is_file($real) && unlink($real)) {
                $this->delEmptyDir(dirname($real));
                $output->writeln("--- 删除 {$file['name']} 文件成功");
            } else {
                $output->error("--- 删除 {$file['name']} 文件失败");
            }
        }
    }

    /**
     * 清理指定的空目录
     * @param string $dir
     */
    private function delEmptyDir($dir)
    {
        if (is_dir($dir) && count(scandir($dir)) === 2) {
            if (rmdir($dir)) $this->delEmptyDir(dirname($dir));
        }
    }

    /**
     * 两二维数组对比
     * @param array $serve 线上文件列表信息
     * @param array $local 本地文件列表信息
     * @return array
     */
    private function contrast(array $serve = [], array $local = [])
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
     * 下载更新文件内容
     * @param string $encode
     * @return boolean|integer
     */
    private function runDown($encode)
    {
        $result = json_decode(http_get("{$this->uri}?s=admin/api.update/read/{$encode}"), true);
        if (empty($result['code'])) return false;
        $pathname = env('root_path') . decode($encode);
        file_exists(dirname($pathname)) || mkdir(dirname($pathname), 0755, true);
        return file_put_contents($pathname, base64_decode($result['data']['content']));
    }

    /**
     * 获取文件差异数据
     * @return array
     */
    private function getDiff()
    {
        $result = json_decode(http_get("{$this->uri}?s=/admin/api.update/tree"), true);
        if (empty($result['code'])) return [];
        $new = $this->tree($result['data']['paths'], $result['data']['ignores']);
        return $this->contrast($result['data']['list'], $new['list']);
    }

    /**
     * 获取目录文件列表
     * @param string $dir 待扫描的目录
     * @param string $root 应用根目录
     * @param array $data 扫描结果
     * @return array
     */
    private function scanDir($dir, $root = '', $data = [])
    {
        if (file_exists($dir) && is_file($dir)) {
            return [$this->getFileInfo($dir, $root)];
        }
        if (file_exists($dir)) foreach (scandir($dir) as $sub) if (strpos($sub, '.') !== 0) {
            if (is_dir($temp = "{$dir}/{$sub}")) {
                $data = array_merge($data, $this->scanDir($temp, $root));
            } else array_push($data, $this->getFileInfo($temp, $root));
        }
        return $data;
    }

    /**
     * 获取指定文件信息
     * @param string $file 绝对文件名
     * @param string $root
     * @return array
     */
    private function getFileInfo($file, $root)
    {
        return [
            'hash' => md5(preg_replace('/\s{1,}/', '', file_get_contents($file))),
            'name' => str_replace($root, '', str_replace('\\', '/', realpath($file))),
        ];
    }

}
