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

namespace think\admin\command;

use think\admin\service\InstallService;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

/**
 * 插件更新安装指令
 * Class Install
 * @package think\admin\command
 */
class Install extends Command
{
    /**
     * 查询规则
     * @var array
     */
    protected $rules = [];

    /**
     * 忽略规则
     * @var array
     */
    protected $ignore = [];

    /**
     * 指定模块名称
     * @var string
     */
    protected $name;

    /**
     * 规则配置
     * @var array
     */
    protected $bind = [
        'admin'  => [
            'rules'  => ['think', 'app/admin'],
            'ignore' => [],
        ],
        'static' => [
            'rules'  => ['public/static'],
            'ignore' => ['public/static/self'],
        ],
    ];

    protected function configure()
    {
        $this->setName('xtask:install');
        $this->setDescription("[安装]安装或更新指定模块");
        $this->addArgument('name', Argument::OPTIONAL, '模块名称', '');
    }

    /**
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $this->name = trim($input->getArgument('name'));
        if (empty($this->name)) {
            $this->output->error('在线安装的模块名称不能为空！');
        } else {

            if (isset($this->bind[$this->name])) {
                $this->rules = empty($this->bind[$this->name]['rules']) ? [] : $this->bind[$this->name]['rules'];
                $this->ignore = empty($this->bind[$this->name]['ignore']) ? [] : $this->bind[$this->name]['ignore'];
                $this->installFile();
                $this->installDatabase();
            } else {
                $this->output->error("指定模块 {$this->name} 未配置安装规则！");
            }
        }
    }

    protected function installFile()
    {
        $data = InstallService::instance()->grenerateDifference($this->rules, $this->ignore);
        if (empty($data)) $this->output->info('文件比对一致不需更新文件！');
        else foreach ($data as $file) {
            list($state, $mode, $name) = InstallService::instance()->fileSynchronization($file);
            if ($state) {
                if ($mode === 'add') $this->output->info("--- 下载 {$name} 添加成功");
                if ($mode === 'mod') $this->output->info("--- 下载 {$name} 更新成功");
                if ($mode === 'del') $this->output->info("--- 删除 {$name} 文件成功");
            } else {
                if ($mode === 'add') $this->output->error("--- 下载 {$name} 添加失败");
                if ($mode === 'mod') $this->output->error("--- 下载 {$name} 更新失败");
                if ($mode === 'del') $this->output->error("--- 删除 {$name} 文件失败");
            }
        }
    }

    protected function installDatabase()
    {

    }

}