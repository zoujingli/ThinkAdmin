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
     * 项目根目录
     * @var string
     */
    private $root;

    /**
     * 线上服务器地址
     * @var string
     */
    private $server;

    /**
     * 初始化服务
     */
    protected function initialize()
    {
        $this->root = strtr($this->app->getRootPath(), '\\', '/');
        $this->server = ModuleService::instance()->getServer();
    }

    /**
     * 获取文件信息列表
     * @param array $rules 文件规则
     * @param array $ignore 忽略规则
     * @param array $data 扫描结果列表
     * @return array
     */
    public function getList(array $rules, array $ignore = [], array $data = []): array
    {
        // 扫描规则文件
        foreach ($rules as $key => $rule) {
            $name = strtr(trim($rule, '\\/'), '\\', '/');
            $data = array_merge($data, $this->_scanList("{$this->root}{$name}"));
        }
        // 清除忽略文件
        foreach ($data as $key => $item) foreach ($ignore as $ign) {
            if (stripos($item['name'], $ign) === 0) unset($data[$key]);
        }
        // 返回文件数据
        return ['rules' => $rules, 'ignore' => $ignore, 'list' => $data];
    }

    /**
     * 获取文件差异数据
     * @param array $rules 文件规则
     * @param array $ignore 忽略规则
     * @return array
     */
    public function grenerateDifference(array $rules = [], array $ignore = []): array
    {
        [$rules1, $ignore1, $data] = [$rules, $ignore, []];
        $result = json_decode(HttpExtend::post("{$this->server}/admin/api.update/node", [
            'rules' => json_encode($rules1), 'ignore' => json_encode($ignore1),
        ]), true);
        if (!empty($result['code'])) {
            $new = $this->getList($result['data']['rules'], $result['data']['ignore']);
            foreach ($this->_grenerateDifferenceContrast($result['data']['list'], $new['list']) as $file) {
                if (in_array($file['type'], ['add', 'del', 'mod'])) foreach ($rules1 as $rule) {
                    if (stripos($file['name'], $rule) === 0) $data[] = $file;
                }
            }
        }
        return $data;
    }

    /**
     * 下载并更新文件
     * @param array $file 文件信息
     * @return array
     */
    public function updateFileByDownload(array $file): array
    {
        if (in_array($file['type'], ['add', 'mod'])) {
            if ($this->_downloadFile(encode($file['name']))) {
                return [true, $file['type'], $file['name']];
            } else {
                return [false, $file['type'], $file['name']];
            }
        } elseif (in_array($file['type'], ['del'])) {
            $real = $this->root . $file['name'];
            if (is_file($real) && unlink($real)) {
                $this->_removeEmptyDirectory(dirname($real));
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
    private function _downloadFile($encode)
    {
        $source = "{$this->server}/admin/api.update/get?encode={$encode}";
        $result = json_decode(HttpExtend::get($source), true);
        if (empty($result['code'])) return false;
        $filename = $this->root . decode($encode);
        file_exists(dirname($filename)) || mkdir(dirname($filename), 0755, true);
        return file_put_contents($filename, base64_decode($result['data']['content']));
    }

    /**
     * 清理空目录
     * @param string $path
     */
    private function _removeEmptyDirectory($path)
    {
        if (is_dir($path) && count(scandir($path)) === 2 && rmdir($path)) {
            $this->_removeEmptyDirectory(dirname($path));
        }
    }

    /**
     * 两二维数组对比
     * @param array $serve 线上文件列表信息
     * @param array $local 本地文件列表信息
     * @return array
     */
    private function _grenerateDifferenceContrast(array $serve = [], array $local = []): array
    {
        // 数据扁平化
        [$_serve, $_local, $_diffy] = [[], [], []];
        foreach ($serve as $t) $_serve[$t['name']] = $t;
        foreach ($local as $t) $_local[$t['name']] = $t;
        unset($serve, $local);
        // 线上数据差异计算
        foreach ($_serve as $t) isset($_local[$t['name']]) ? array_push($_diffy, [
            'type' => $t['hash'] === $_local[$t['name']]['hash'] ? null : 'mod', 'name' => $t['name'],
        ]) : array_push($_diffy, ['type' => 'add', 'name' => $t['name']]);
        // 本地数据增量计算
        foreach ($_local as $t) if (!isset($_serve[$t['name']])) array_push($_diffy, ['type' => 'del', 'name' => $t['name']]);
        unset($_serve, $_local);
        usort($_diffy, function ($a, $b) {
            return $a['name'] !== $b['name'] ? ($a['name'] > $b['name'] ? 1 : -1) : 0;
        });
        return $_diffy;
    }

    /**
     * 获取指定文件信息
     * @param string $path 文件路径
     * @return array
     */
    private function _getInfo($path): array
    {
        return [
            'name' => str_replace($this->root, '', $path),
            'hash' => md5(preg_replace('/\s+/', '', file_get_contents($path))),
        ];
    }

    /**
     * 获取目录文件列表
     * @param string $path 待扫描目录
     * @param array $data 扫描结果
     * @return array
     */
    private function _scanList($path, $data = []): array
    {
        foreach (NodeService::instance()->scanDirectory($path, [], null) as $file) {
            $data[] = $this->_getInfo(strtr($file, '\\', '/'));
        }
        return $data;
    }
}