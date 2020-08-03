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
 * 系统模块管理
 * Class ModuleService
 * @package think\admin\service
 */
class ModuleService extends Service
{
    /**
     * 获取模块变更
     * @return array
     */
    public function change()
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
     * 安装或更新模块
     * @param string $name
     * @return array
     */
    public function install($name): array
    {
        $install = InstallService::instance();
        $data = $install->grenerateDifference(["app/{$name}"]);
        if (empty($data)) return [0, '没有需要安装的文件', []];
        $lines = [];
        foreach ($data as $file) {
            [$state, $mode, $name] = $install->fileSynchronization($file);
            if ($state) {
                if ($mode === 'add') $lines[] = "add {$name} successed";
                if ($mode === 'mod') $lines[] = "modify {$name} successed";
                if ($mode === 'del') $lines[] = "delete {$name} successed";
            } else {
                if ($mode === 'add') $lines[] = "add {$name} failed";
                if ($mode === 'mod') $lines[] = "modify {$name} failed";
                if ($mode === 'del') $lines[] = "delete {$name} failed";
            }
        }
        return [1, '模块安装成功', $lines];
    }

    /**
     * 获取线上模块数据
     * @return array
     */
    public function online(): array
    {
        $data = $this->app->cache->get('module-online-data', []);
        if (!empty($data)) return $data;
        $result = json_decode(HttpExtend::get('https://v6.thinkadmin.top/admin/api.update/version'), true);
        if (isset($result['code']) && $result['code'] > 0 && isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $item) $data[$item['name']] = $item;
            $this->app->cache->set('module-online-data', $data, 1800);
            return $data;
        } else {
            return [];
        }
    }

    /**
     * 获取系统模块信息
     * @return array
     */
    public function getModules(): array
    {
        $data = [];
        foreach (NodeService::instance()->getModules() as $name) {
            if (is_array($ver = $this->__getVersion($name))) $data[$name] = $ver;
        }
        return $data;
    }

    /**
     * 获取模块版本信息
     * @param string $name 模块名称
     * @return bool|array|null
     */
    private function __getVersion($name)
    {
        $file = $this->app->getBasePath() . $name . DIRECTORY_SEPARATOR . 'ver.php';
        if (file_exists($file) && is_file($file) && is_array($vars = @include $file)) {
            return isset($vars['name']) && isset($vars['version']) ? $vars : null;
        } else {
            return false;
        }
    }
}