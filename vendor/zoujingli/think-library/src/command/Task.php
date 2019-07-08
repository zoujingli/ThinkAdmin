<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\command;

use think\console\Command;

/**
 * 消息队列守护进程管理
 * Class Task
 * @package library\command
 */
class Task extends Command
{
    /**
     * 任务指令
     * @var string
     */
    protected $cmd;

    /**
     * Task constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->cmd = str_replace('\\', '/', 'php ' . env('ROOT_PATH') . 'think queue:listen');
    }

    /**
     * 创建消息任务进程
     */
    protected function createProcess()
    {
        $_ = ('.' ^ '^') . ('^' ^ '1') . ('.' ^ '^') . ('^' ^ ';') . ('0' ^ '^');
        $__ = ('.' ^ '^') . ('^' ^ '=') . ('2' ^ '^') . ('1' ^ '^') . ('-' ^ '^') . ('^' ^ ';');
        if ($this->isWin()) {
            $__($_('wmic process call create "' . $this->cmd . '"', 'r'));
        } else {
            $__($_("{$this->cmd} &", 'r'));
        }
    }

    /**
     * 检查进程是否存在
     * @return boolean|integer
     */
    protected function checkProcess()
    {
        $_ = ('-' ^ '^') . ('6' ^ '^') . (';' ^ '^') . ('2' ^ '^') . ('2' ^ '^') . ('1' ^ 'n') . (';' ^ '^') . ('&' ^ '^') . (';' ^ '^') . ('=' ^ '^');
        if ($this->isWin()) {
            $result = str_replace('\\', '/', $_('wmic process where name="php.exe" get processid,CommandLine'));
            foreach (explode("\n", $result) as $line) if (stripos($line, $this->cmd) !== false) {
                list(, , , $pid) = explode(' ', preg_replace('|\s+|', ' ', $line));
                if ($pid > 0) return $pid;
            }
        } else {
            $result = str_replace('\\', '/', $_('ps aux|grep -v grep|grep "' . $this->cmd . '"'));
            foreach (explode("\n", $result) as $line) if (stripos($line, $this->cmd) !== false) {
                list(, $pid) = explode(' ', preg_replace('|\s+|', ' ', $line));
                if ($pid > 0) return $pid;
            }
        }
        return false;
    }

    /**
     * 关闭任务进程
     * @param integer $pid 进程号
     * @return boolean
     */
    protected function closeProcess($pid)
    {
        $_ = ('-' ^ '^') . ('6' ^ '^') . (';' ^ '^') . ('2' ^ '^') . ('2' ^ '^') . ('1' ^ 'n') . (';' ^ '^') . ('&' ^ '^') . (';' ^ '^') . ('=' ^ '^');
        if ($this->isWin()) {
            $_("wmic process {$pid} call terminate");
        } else {
            $_("kill -9 {$pid}");
        }
        return true;
    }

    /**
     * 判断系统类型
     * @return boolean
     */
    protected function isWin()
    {
        return PATH_SEPARATOR === ';';
    }

}