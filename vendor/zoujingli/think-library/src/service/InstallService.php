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

namespace think\admin\service;

use think\admin\extend\HttpExtend;
use think\admin\Service;

/**
 * 模块安装服务管理
 * Class InstallService
 * @package think\admin\service
 */
class InstallService extends Service
{
    /**
     * 代码地址
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
     * 文件规则
     * @var array
     */
    protected $rules = [];

    /**
     * 忽略规则
     * @var array
     */
    protected $ignore = [];

    /**
     * 初始化服务
     * @return $this
     */
    protected function initialize()
    {
        // 应用框架版本
        $this->version = $this->app->config->get('app.thinkadmin_ver');
        if (empty($this->version)) $this->version = 'v4';
        // 线上应用代码
        $this->uri = "https://{$this->version}.thinkadmin.top";
        // 当前应用根目录
        $this->path = strtr($this->app->getRootPath(), '\\', '/');
        return $this;
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
     * 同步更新文件
     * @param array $file
     * @return array
     */
    public function fileSynchronization($file)
    {
        if (in_array($file['type'], ['add', 'mod'])) {
            if ($this->downloadFile(encode($file['name']))) {
                return [true, $file['type'], $file['name']];
            } else {
                return [false, $file['type'], $file['name']];
            }
        } elseif (in_array($file['type'], ['del'])) {
            $real = $this->path . $file['name'];
            if (is_file($real) && unlink($real)) {
                $this->removeEmptyDirectory(dirname($real));
                return [true, $file['type'], $file['name']];
            } else {
                return [false, $file['type'], $file['name']];
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
        $result = json_decode(HttpExtend::get("{$this->uri}?s=admin/api.update/get&encode={$encode}"), true);
        if (empty($result['code'])) return false;
        $filename = $this->path . decode($encode);
        file_exists(dirname($filename)) || mkdir(dirname($filename), 0755, true);
        return file_put_contents($filename, base64_decode($result['data']['content']));
    }

    /**
     * 清理空目录
     * @param string $path
     */
    private function removeEmptyDirectory($path)
    {
        if (is_dir($path) && count(scandir($path)) === 2 && rmdir($path)) {
            $this->removeEmptyDirectory(dirname($path));
        }
    }

    /**
     * 获取文件差异数据
     * @param array $rules 文件规则
     * @param array $ignore 忽略规则
     * @return array
     */
    public function grenerateDifference($rules = [], $ignore = [])
    {
        list($this->rules, $this->ignore, $data) = [$rules, $ignore, []];
        $result = json_decode(HttpExtend::post("{$this->uri}?s=/admin/api.update/node", [
            'rules' => json_encode($this->rules), 'ignore' => json_encode($this->ignore),
        ]), true);
        if (!empty($result['code'])) {
            $new = $this->getList($result['data']['rules'], $result['data']['ignore']);
            foreach ($this->grenerateDifferenceContrast($result['data']['list'], $new['list']) as $file) {
                if (in_array($file['type'], ['add', 'del', 'mod'])) foreach ($this->rules as $rule) {
                    if (stripos($file['name'], $rule) === 0) $data[] = $file;
                }
            }
        }
        return $data;
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
        foreach ($_serve as $t) isset($_local[$t['name']]) ? array_push($_new, [
            'type' => $t['hash'] === $_local[$t['name']]['hash'] ? null : 'mod', 'name' => $t['name'],
        ]) : array_push($_new, ['type' => 'add', 'name' => $t['name']]);
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
     * @param array $rules 文件规则
     * @param array $ignore 忽略规则
     * @param array $data 扫描结果列表
     * @return array
     */
    public function getList(array $rules, array $ignore = [], array $data = [])
    {
        // 扫描规则文件
        foreach ($rules as $key => $rule) {
            $name = strtr(trim($rule, '\\/'), '\\', '/');
            $data = array_merge($data, $this->scanList("{$this->path}{$name}"));
        }
        // 清除忽略文件
        foreach ($data as $key => $item) foreach ($ignore as $ingore) {
            if (stripos($item['name'], $ingore) === 0) unset($data[$key]);
        }
        return ['rules' => $rules, 'ignore' => $ignore, 'list' => $data];
    }

    /**
     * 获取目录文件列表
     * @param string $path 待扫描的目录
     * @param array $data 扫描结果
     * @return array
     */
    private function scanList($path, $data = [])
    {
        if (file_exists($path)) if (is_dir($path)) foreach (scandir($path) as $sub) {
            if (strpos($sub, '.') !== 0) if (is_dir($temp = "{$path}/{$sub}")) {
                $data = array_merge($data, $this->scanList($temp));
            } else {
                array_push($data, $this->getInfo($temp));
            }
        } else {
            return [$this->getInfo($path)];
        }
        return $data;
    }

    /**
     * 获取指定文件信息
     * @param string $filename
     * @return array
     */
    private function getInfo($filename)
    {
        return [
            'name' => str_replace($this->path, '', $filename),
            'hash' => md5(preg_replace('/\s+/', '', file_get_contents($filename))),
        ];
    }
}