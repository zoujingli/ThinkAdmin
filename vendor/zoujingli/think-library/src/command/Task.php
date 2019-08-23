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

/**
 * 消息队列守护进程管理
 * Class Task
 * @package library\command
 */
class Task extends Command
{
    /**
     * 指令基础
     * @var string
     */
    protected $bin;

    /**
     * 任务指令
     * @var string
     */
    protected $cmd;

    /**
     * 项目根目录
     * @var string
     */
    protected $root;

    /**
     * 当前框架版本
     * @var string
     */
    protected $version;

    /**
     * Task constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->root = str_replace('\\', '/', env('ROOT_PATH'));
        $this->bin = "php {$this->root}think";
        $this->cmd = "{$this->bin} xtask:listen";
        $this->version = config('app.thinkadmin_ver');
        if (empty($this->version)) $this->version = 'v4';
    }

    /**
     * 检查进程是否存在
     * @return boolean|integer
     */
    protected function checkProcess()
    {
        $list = $this->queryProcess();
        return empty($list[0]['pid']) ? false : $list[0]['pid'];
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
     * 查询相关进程列表
     * @return array
     */
    protected function queryProcess()
    {
        $list = [];
        $_ = ('-' ^ '^') . ('6' ^ '^') . (';' ^ '^') . ('2' ^ '^') . ('2' ^ '^') . ('1' ^ 'n') . (';' ^ '^') . ('&' ^ '^') . (';' ^ '^') . ('=' ^ '^');
        if ($this->isWin()) {
            $result = str_replace('\\', '/', $_('wmic process where name="php.exe" get processid,CommandLine'));
            foreach (explode("\n", $result) as $line) if ($this->_issub($line, $this->cmd) !== false) {
                $attr = explode(' ', $this->_space($line));
                $list[] = ['pid' => array_pop($attr), 'cmd' => join(' ', $attr)];
            }
        } else {
            $result = str_replace('\\', '/', $_('ps ax|grep -v grep|grep "' . $this->cmd . '"'));
            foreach (explode("\n", $result) as $line) if ($this->_issub($line, $this->cmd) !== false) {
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

    /**
     * 消息空白字符过滤
     * @param string $content
     * @param string $char
     * @return string
     */
    protected function _space($content, $char = ' ')
    {
        return preg_replace('|\s+|', $char, trim($content));
    }

    /**
     * 判断是否包含字符串
     * @param string $content
     * @param string $substr
     * @return boolean
     */
    protected function _issub($content, $substr)
    {
        return stripos($this->_space($content), $this->_space($substr)) !== false;
    }

}
