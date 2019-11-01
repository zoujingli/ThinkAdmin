<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\extend;

/**
 * 系统进程管理扩展
 * Class ProcessExtend
 * @package think\admin\extend
 */
class ProcessExtend
{

    /**
     * 创建并获取Think指令内容
     * @param string $args 指定参数
     * @return string
     */
    public static function think($args = '')
    {
        $root = app()->getRootPath();
        return trim("php {$root}think {$args}");
    }

    /**
     * 获取当前应用版本
     * @return string
     */
    public static function version()
    {
        return app()->config->get('app.thinkadmin_ver', 'v4');
    }

    /**
     * 创建异步进程
     * @param string $command 任务指令
     */
    public static function create($command)
    {
        if (self::iswin()) {
            $command = __DIR__ . "/bin/console.exe {$command}";
            pclose(popen("wmic process call create \"{$command}\"", 'r'));
        } else {
            pclose(popen("{$command} &", 'r'));
        }
    }

    /**
     * 立即执行指令
     * @param string $command 执行指令
     * @return string
     */
    public static function exec($command)
    {
        return shell_exec($command);
    }

    /**
     * 查询相关进程列表
     * @param string $command 任务指令
     * @return array
     */
    public static function query($command)
    {
        $list = [];
        if (self::iswin()) {
            $result = self::exec('wmic process where name="php.exe" get processid,CommandLine');
            foreach (explode("\n", $result) as $line) if (self::_issub($line, $command) !== false) {
                $attr = explode(' ', self::_space($line));
                $list[] = ['pid' => array_pop($attr), 'cmd' => join(' ', $attr)];
            }
        } else {
            $result = self::exec('ps ax|grep -v grep|grep "' . $command . '"');
            foreach (explode("\n", $result) as $line) if (self::_issub($line, $command) !== false) {
                $attr = explode(' ', self::_space($line));
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
    public static function close($pid)
    {
        if (self::iswin()) {
            self::exec("wmic process {$pid} call terminate");
        } else {
            self::exec("kill -9 {$pid}");
        }
        return true;
    }

    /**
     * 判断系统类型
     * @return boolean
     */
    public static function iswin()
    {
        return PATH_SEPARATOR === ';';
    }

    /**
     * 消息空白字符过滤
     * @param string $content
     * @param string $char
     * @return string
     */
    private static function _space($content, $char = ' ')
    {
        return preg_replace('|\s+|', $char, strtr(trim($content), '\\', '/'));
    }

    /**
     * 判断是否包含字符串
     * @param string $content
     * @param string $substr
     * @return boolean
     */
    private static function _issub($content, $substr)
    {
        return stripos(self::_space($content), self::_space($substr)) !== false;
    }

}