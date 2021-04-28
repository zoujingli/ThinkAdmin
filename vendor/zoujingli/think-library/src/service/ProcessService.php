<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\service;

use think\admin\Service;

/**
 * 系统进程管理服务
 * Class ProcessService
 * @package think\admin\service
 */
class ProcessService extends Service
{

    /**
     * 获取 Think 指令内容
     * @param string $args 指定参数
     * @param boolean $simple 指令内容
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function think(string $args = '', $simple = false): string
    {
        if ($simple) {
            return trim("{$this->app->getRootPath()}think {$args}");
        } else {
            $binary = sysconf('base.binary') ?: 'php';
            return trim("{$binary} {$this->app->getRootPath()}think {$args}");
        }
    }

    /**
     * 检查 Think 运行进程
     * @param string $args
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function thinkQuery(string $args): array
    {
        return $this->query($this->think($args, true));
    }

    /**
     * 执行 Think 指令内容
     * @param string $args 执行参数
     * @param integer $usleep 延时时间
     * @return ProcessService
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function thinkCreate(string $args, $usleep = 0): ProcessService
    {
        return $this->create($this->think($args), $usleep);
    }

    /**
     * 获取当前应用版本
     * @return string
     */
    public function version(): string
    {
        return ModuleService::instance()->getVersion();
    }

    /**
     * 创建异步进程
     * @param string $command 任务指令
     * @param integer $usleep 延时时间
     * @return $this
     */
    public function create(string $command, $usleep = 0): ProcessService
    {
        if ($this->iswin()) {
            $this->exec(__DIR__ . "/bin/console.exe {$command}");
        } else {
            $this->exec("{$command} > /dev/null 2>&1 &");
        }
        if ($usleep > 0) {
            usleep($usleep);
        }
        return $this;
    }

    /**
     * 查询相关进程列表
     * @param string $command 任务指令
     * @param string $name 执行名称
     * @return array
     */
    public function query(string $command, $name = 'php.exe'): array
    {
        $list = [];
        if ($this->iswin()) {
            $lines = $this->exec('wmic process where name="' . $name . '" get processid,CommandLine', true);
            foreach ($lines as $line) if ($this->_issub($line, $command) !== false) {
                $attr = explode(' ', $this->_space($line));
                $list[] = ['pid' => array_pop($attr), 'cmd' => join(' ', $attr)];
            }
        } else {
            $lines = $this->exec("ps ax|grep -v grep|grep \"{$command}\"", true);
            foreach ($lines as $line) if ($this->_issub($line, $command) !== false) {
                $attr = explode(' ', $this->_space($line));
                [$pid] = [array_shift($attr), array_shift($attr), array_shift($attr), array_shift($attr)];
                $list[] = ['pid' => $pid, 'cmd' => join(' ', $attr)];
            }
        }
        return $list;
    }

    /**
     * 关闭任务进程
     * @param integer $pid 进程号
     * @return boolean
     */
    public function close(int $pid): bool
    {
        if ($this->iswin()) {
            $this->exec("wmic process {$pid} call terminate");
        } else {
            $this->exec("kill -9 {$pid}");
        }
        return true;
    }

    /**
     * 立即执行指令
     * @param string $command 执行指令
     * @param boolean $outarr 返回类型
     * @return string|array
     */
    public function exec(string $command, $outarr = false)
    {
        exec($command, $output);
        return $outarr ? $output : join("\n", $output);
    }

    /**
     * 判断系统类型
     * @return boolean
     */
    public function iswin(): bool
    {
        return PATH_SEPARATOR === ';';
    }

    /**
     * 清除空白字符过滤
     * @param string $content
     * @param string $tochar
     * @return string
     */
    private function _space(string $content, string $tochar = ' '): string
    {
        return preg_replace('|\s+|', $tochar, strtr(trim($content), '\\', '/'));
    }

    /**
     * 判断是否包含字符串
     * @param string $content
     * @param string $substr
     * @return boolean
     */
    private function _issub(string $content, string $substr): bool
    {
        return stripos($this->_space($content), $this->_space($substr)) !== false;
    }
}