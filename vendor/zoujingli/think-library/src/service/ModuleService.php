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
use think\admin\extend\Parsedown;
use think\admin\Service;

/**
 * 系统模块管理
 * Class ModuleService
 * @package think\admin\service
 */
class ModuleService extends Service
{
    /**
     * 官方应用地址
     * @var string
     */
    protected $server;

    /**
     * 官方应用版本
     * @var string
     */
    protected $version;

    /**
     * 服务初始化
     */
    public function initialize()
    {
        $full = $this->app->config->get('app.thinkadmin_ver', 'v4.0.0');
        $this->version = trim($full, 'v');
        $version = strstr($full . '.', '.', true);
        $this->server = "https://{$version}.thinkadmin.top";
    }

    /**
     * 获取服务端地址
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * 获取版本号信息
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * 获取模块变更
     * @return array
     */
    public function change(): array
    {
        [$online, $locals] = [$this->online(), $this->getModules()];
        foreach ($online as &$item) if (isset($locals[$item['name']])) {
            $item['local'] = $locals[$item['name']];
            if ($item['local']['version'] < $item['version']) {
                $item['type_code'] = 2;
                $item['type_desc'] = '需要更新';
            } else {
                $item['type_code'] = 3;
                $item['type_desc'] = '无需更新';
            }
        } else {
            $item['type_code'] = 1;
            $item['type_desc'] = '未安装';
        }
        return $online;
    }


    /**
     * 获取线上模块数据
     * @return array
     */
    public function online(): array
    {
        $data = $this->app->cache->get('moduleOnlineData', []);
        if (!empty($data)) return $data;
        $result = json_decode(HttpExtend::get($this->server . '/admin/api.update/version'), true);
        if (isset($result['code']) && $result['code'] > 0 && isset($result['data']) && is_array($result['data'])) {
            $this->app->cache->set('moduleOnlineData', $result['data'], 30);
            return $result['data'];
        } else {
            return [];
        }
    }

    /**
     * 安装或更新模块
     * @param string $name 模块名称
     * @return array
     */
    public function install($name): array
    {
        $install = InstallService::instance();
        $this->app->cache->set('moduleOnlineData', []);
        $data = $install->grenerateDifference(['app' . '/' . $name]);
        if (empty($data)) return [0, '没有需要安装的文件', []];
        $lines = [];
        foreach ($data as $file) {
            [$state, $mode, $name] = $install->updateFileByDownload($file);
            if ($state) {
                if ($mode === 'add') $lines[] = "add {$name} successed";
                if ($mode === 'mod') $lines[] = "modify {$name} successed";
                if ($mode === 'del') $lines[] = "deleted {$name} successed";
            } else {
                if ($mode === 'add') $lines[] = "add {$name} failed";
                if ($mode === 'mod') $lines[] = "modify {$name} failed";
                if ($mode === 'del') $lines[] = "deleted {$name} failed";
            }
        }
        return [1, '模块安装成功', $lines];
    }

    /**
     * 获取系统模块信息
     * @param array $data
     * @return array
     */
    public function getModules(array $data = []): array
    {
        $service = NodeService::instance();
        foreach ($service->getModules() as $name) {
            $vars = $this->_getModuleVersion($name);
            if (is_array($vars) && isset($vars['version']) && preg_match('|^\d{4}\.\d{2}\.\d{2}\.\d{2}$|', $vars['version'])) {
                $data[$name] = array_merge($vars, ['change' => []]);
                foreach ($service->scanDirectory($this->_getModulePath($name) . 'change/', [], 'md') as $file) {
                    $data[$name]['change'][pathinfo($file, PATHINFO_FILENAME)] = Parsedown::instance()->parse(file_get_contents($file));
                }
            }
        }
        return $data;
    }

    /**
     * 获取允许下载的规则
     * @return array
     */
    public function getAllowDownloadRule(): array
    {
        $data = $this->app->cache->get('moduleAllowRule', []);
        if (is_array($data) && count($data) > 0) return $data;
        $data = ['config', 'public/static'];
        foreach (array_keys($this->getModules()) as $name) $data[] = "app/{$name}";
        $this->app->cache->set('moduleAllowRule', $data, 30);
        return $data;
    }

    /**
     * 检查文件是否可下载
     * @param string $name 文件名称
     * @return boolean
     */
    public function checkAllowDownload($name): bool
    {
        // 禁止下载数据库配置文件
        if (stripos($name, 'database.php') !== false) {
            return false;
        }
        // 检查允许下载的文件规则
        foreach ($this->getAllowDownloadRule() as $rule) {
            if (stripos($name, $rule) !== false) return true;
        }
        // 不在允许下载的文件规则
        return false;
    }

    /**
     * 获取模块版本信息
     * @param string $name 模块名称
     * @return bool|array|null
     */
    private function _getModuleVersion($name)
    {
        $filename = $this->_getModulePath($name) . 'module.json';
        if (file_exists($filename) && is_file($filename) && is_readable($filename)) {
            $vars = json_decode(file_get_contents($filename), true);
            return isset($vars['name']) && isset($vars['version']) ? $vars : null;
        } else {
            return false;
        }
    }

    /**
     * 获取模块信息路径
     * @param string $name
     * @return string
     */
    private function _getModulePath($name)
    {
        $appdir = $this->app->getBasePath() . $name;
        return $appdir . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR;
    }
}