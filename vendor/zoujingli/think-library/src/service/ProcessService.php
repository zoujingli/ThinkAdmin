<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
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
     * @return ProcessService
     */
    public function create($command)
    {
        if ($this->iswin()) {
            $command = __DIR__ . "/bin/console.exe {$command}";
            pclose(popen("wmic process call create \"{$command}\"", 'r'));
        } else {
            pclose(popen("{$command} &", 'r'));
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
            $result = $this->exec('wmic process where name="php.exe" get processid,CommandLine');
            foreach (explode("\n", $result) as $line) if ($this->_issub($line, $command) !== false) {
                $attr = explode(' ', $this->_space($line));
                $list[] = ['pid' => array_pop($attr), 'cmd' => join(' ', $attr)];
            }
        } else {
            $result = $this->exec("ps ax|grep -v grep|grep \"{$command}\"");
            foreach (explode("\n", $result) as $line) if ($this->_issub($line, $command) !== false) {
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
     * @return boolean
     */
    public function close($pid)
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
     * @return string
     */
    public function exec($command)
    {
        return shell_exec($command);
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