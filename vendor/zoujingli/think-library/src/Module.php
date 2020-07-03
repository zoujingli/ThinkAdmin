<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin;

use ZipArchive;

/**
 * 应用模块安装服务
 * Class Module
 * @package think\admin
 */
abstract class Module extends Service
{
    abstract public function getName();

    abstract public function getTitle();

    abstract public function getRemark();

    abstract public function getVersion();

    abstract public function callUpdate();

    abstract public function callInstall();

    /**
     * 安装应用模块
     * @param ZipArchive $zip 安装包
     * @return array
     */
    protected function _install(ZipArchive $zip): array
    {
        // 安装包检查
        list($state, $message) = $this->_checkzip($zip);
        if (empty($state)) return [$state, $message];
        // 执行文件安装
        if ($zip->extractTo($this->app->getBasePath() . $this->getName())) {
            return [1, '应用模块安装成功'];
        } else {
            return [0, '应用模块安装失败'];
        }
    }

    /**
     * 移除应用模块
     * @return array
     */
    protected function _remove(): array
    {
        $directory = $this->app->getBasePath() . $this->getName();
        if (file_exists($directory) && is_dir($directory)) {
            return [0, '提交移除应用模块指令成功'];
        } else {
            return [1, '待删除的应用模块不存在'];
        }
    }

    /**
     * 检测安装包是否正常
     * @param ZipArchive $zip 安装包
     * @return array
     */
    protected function _checkzip(ZipArchive $zip): array
    {
        $directory = "{$zip->filename}.files";
        file_exists($directory) || mkdir($directory, 0755, true);
        // 尝试解压应用包
        if ($zip->extractTo($directory) === false) {
            return [0, '应用模块压缩文件解压失败'];
        }
        // 检测应用配置文件
        $info = @include($directory . DIRECTORY_SEPARATOR . 'app.php');
        // 删除临时解压的文件
        $this->_forceRemove($directory);
        // 返回应用模块检查结果
        if (empty($info)) {
            return [0, '未获取到应用模块配置信息'];
        } elseif ($info['name'] !== $this->getName()) {
            return [0, '应用模块名称与注册名称不一致'];
        } else {
            return [1, '应用模块基础检查通过'];
        }
    }

    /**
     * 强制删除指定的目录
     * @param string $directory
     */
    private function _forceRemove(string $directory)
    {
        if (file_exists($directory) && is_dir($directory) && $handle = opendir($directory)) {
            while (false !== ($item = readdir($handle))) if (!in_array($item, ['.', '..'])) {
                $this->_forceRemove("{$directory}/{$item}");
            }
            [closedir($handle), rmdir($directory)];
        } else {
            file_exists($directory) && is_file($directory) && @unlink($directory);
        }
    }
}