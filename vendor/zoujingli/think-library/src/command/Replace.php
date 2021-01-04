<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\command;

use think\admin\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\helper\Str;

/**
 * 数据库字符替换
 * Class Replace
 * @package app\wechat\command
 */
class Replace extends Command
{
    protected function configure()
    {
        $this->setName('xadmin:replace');
        $this->addArgument('search', Argument::OPTIONAL, '查找替换的字符内容', '');
        $this->addArgument('replace', Argument::OPTIONAL, '目标替换的字符内容', '');
        $this->setDescription('Database Character Field Replace for ThinkAdmin');
    }

    /**
     * 执行指令
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws \think\db\exception\DbException
     * @throws \think\admin\Exception
     */
    protected function execute(Input $input, Output $output)
    {
        $search = $input->getArgument('search');
        $repalce = $input->getArgument('replace');
        if ($search === '') $this->queue->error('查找替换字符内容不能为空！');
        if ($repalce === '') $this->queue->error('目标替换字符内容不能为空！');

        [$count, $used] = [count($tables = $this->getTables()), 0];
        foreach ($tables as $table) {
            $data = [];
            $this->queue->message($count, ++$used, sprintf("准备替换数据表 %s", Str::studly($table)));
            foreach ($this->app->db->table($table)->getFields() as $field => $attrs) {
                if (preg_match('/char|text/', $attrs['type'])) {
                    $data[$field] = $this->app->db->raw(sprintf('REPLACE(`%s`,"%s","%s")', $field, $search, $repalce));
                }
            }
            if (count($data) > 0) {
                if ($this->app->db->table($table)->where('1=1')->update($data) !== false) {
                    $this->queue->message($count, $used, sprintf("成功替换数据表 %s", Str::studly($table)), 1);
                } else {
                    $this->queue->message($count, $used, sprintf("失败替换数据表 %s", Str::studly($table)), 1);
                }
            } else {
                $this->queue->message($count, $used, sprintf("无需替换数据表 %s", Str::studly($table)), 1);
            }
        }
        $this->queue->success('批量替换成功');
    }

    /**
     * 获取数据库的数据表
     * @return array
     */
    protected function getTables(): array
    {
        $tables = [];
        foreach ($this->app->db->query("show tables") as $item) {
            $tables = array_merge($tables, array_values($item));
        }
        return $tables;
    }
}