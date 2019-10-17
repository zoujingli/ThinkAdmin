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

namespace app\company\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

/**
 * SVN 版本指令
 * Class Subversion
 * @package app\company\command
 */
class Subversion extends Command
{
    /**
     * 账号授权文件位置
     * @var string
     */
    protected $authzFile = 'php://output';

    /**
     * 账号管理文件位置
     * @var string
     */
    protected $passwdFile = 'php://output';

    /**
     * 配置指令配置
     */
    protected function configure()
    {
        $this->setName('xsubversion:config')->setDescription('从数据库的配置同步到SVN配置文件');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return int|void|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function execute(Input $input, Output $output)
    {
        $paths = ['/' => [0]];
        $where = ['status' => '1', 'is_deleted' => '0'];
        // 取得可用的用户账号
        $users = Db::name('CompanyUser')->field('svn_username,svn_password,svn_authorize')->where($where)->select();
        $authids = array_unique(explode(',', join(',', array_column($users, 'svn_authorize'))));
        // 取得可用的权限配置
        $userAuths = Db::name('CompanyUserAuth')->field('id,path')->where($where)->whereIn('id', $authids)->order('sort desc,id desc')->select();
        foreach ($userAuths as $item) foreach (explode("\n", preg_replace('/\s+/i', "\n", trim($item['path']))) as $path) {
            $paths[$path][] = $item['id'];
        }
        $this->writeAuth($users, $paths);
    }

    /**
     * 写入 SVN 配置文件
     * @param array $users
     * @param array $paths
     */
    protected function writeAuth($users, $paths)
    {
        $output = [];
        // Passwd 用户账号处理
        foreach ($users as $user) $output[] = "{$user['svn_username']}={$user['svn_password']}";
        file_put_contents($this->passwdFile, join(PHP_EOL, $output));
        // Authz 授权配置处理
        $groups = ['_0' => []];
        foreach ($users as $user) {
            $ids = array_unique(explode(',', $user['svn_authorize']));
            foreach ($ids as $id) $groups["_{$id}"][] = $user['svn_username'];
        }
        $output = [];
        $output[] = '[groups]';
        foreach ($groups as $key => $group) $output[] = "group{$key}=" . join(',', $group);
        $output[] = '';
        foreach ($paths as $path => $ids) {
            $output[] = "[{$path}]";
            $output[] = "* =";
            $output[] = '@group_0 = rw';
            foreach ($ids as $id) if ($id > 0) $output[] = "@group_{$id} = rw";
            $output[] = '';
        }
        file_put_contents($this->authzFile, join(PHP_EOL, $output));
    }
}
