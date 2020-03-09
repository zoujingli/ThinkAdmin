<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace library\service;

use library\Service;

/**
 * 系统进程管理服务
 * Class ProcessService
 * @package think\admin\service
 */
class ProcessService extends Service
{

    /**
     * 创建并获取Think指令内容
     * @param string $args 指定参数
     * @return string
     */
    public function think($args = '')
    {
        $root = $this->app->getRootPath();
        return trim("php {$root}think {$args}");
    }

    /**
     * 获取当前应用版本
     * @return string
     */
    public function version()
    {
        return $this->app->config->get('app.thinkadmin_ver', 'v4');
    }

    /**
     * 创建异步进程
     * @param string $command 任务指令
     * @return $this
     */
    public function create($command)
    {
        if ($this->iswin()) {
            $this->exec(__DIR__ . "/bin/console.exe {$command}");
        } else {
            $this->exec("{$command} > /dev/null &");
        }
        return $this;
    }

    /**
     * 查询相关进程列表
     * @param string $command 任务指令
     * @return array
     */
    public function query($command)
    {
        $list = [];
        if ($this->iswin()) {
            $lines = $this->exec('wmic process where name="php.exe" get processid,CommandLine', true);
            foreach ($lines as $line) if ($this->_issub($line, $command) !== false) {
                $attr = explode(' ', $this->_space($line));
                $list[] = ['pid' => array_pop($attr), 'cmd' => join(' ', $attr)];
            }
        } else {
            $lines = $this->exec("ps ax|grep -v grep|grep \"{$command}\"", true);
            foreach ($lines as $line) if ($this->_issub($line, $command) !== false) {
                $attr = explode(' ', $this->_space($line));
                list($pid) = [array_shift($attr), array_shift($attr), array_shift($attr), array_shift($attr)];
                $list[] = ['pid' => $pid, 'cmd' => join(' ', $attr)];
            }
        }
        return $list;
    }

    /**
     * 关闭任务进程
     * @param integer $pid 进程号
     * @return $this
     */
    public function close($pid)
    {
        if ($this->iswin()) {
            $this->exec("wmic process {$pid} call terminate");
        } else {
            $this->exec("kill -9 {$pid}");
        }
        return $this;
    }

    /**
     * 立即执行指令
     * @param string $command 执行指令
     * @param boolean $outarr 返回类型
     * @return string|array
     */
    public function exec($command, $outarr = false)
    {
        exec($command, $output);
        return $outarr ? $output : join("\n", $output);
    }

    /**
     * 判断系统类型
     * @return boolean
     */
    public function iswin()
    {
        return PATH_SEPARATOR === ';';
    }

    /**
     * 消息空白字符过滤
     * @param string $content
     * @param string $tochar
     * @return string
     */
    private function _space($content, $tochar = ' ')
    {
        return preg_replace('|\s+|', $tochar, strtr(trim($content), '\\', '/'));
    }

    /**
     * 判断是否包含字符串
     * @param string $content
     * @param string $substr
     * @return boolean
     */
    private function _issub($content, $substr)
    {
        return stripos($this->_space($content), $this->_space($substr)) !== false;
    }
}