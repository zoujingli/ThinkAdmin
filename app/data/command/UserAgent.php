<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\command;

use app\data\model\DataUser;
use app\data\service\UserUpgradeService;
use think\admin\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

/**
 * 更新用户代理关系
 * Class UserAgent
 * @package app\data\command
 */
class UserAgent extends Command
{
    protected function configure()
    {
        $this->setName('xdata:UserAgent');
        $this->addArgument('uuid', Argument::OPTIONAL, '目标用户', '');
        $this->addArgument('puid', Argument::OPTIONAL, '上级代理', '');
        $this->setDescription('重新设置用户上级代理, 参数：UUID PUID');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function execute(Input $input, Output $output)
    {
        [$uuid, $puid] = [$input->getArgument('uuid'), $input->getArgument('puid')];
        if (empty($uuid)) $this->setQueueError("参数UID无效，请传入正确的参数!");
        if (empty($puid)) $this->setQueueError("参数PID无效，请传入正确的参数!");

        // 检查当前用户资料
        $user = DataUser::mk()->where(['id' => $uuid])->find();
        if (empty($user)) $this->setQueueError("读取用户数据失败!");

        // 检查上级代理用户
        $parant = DataUser::mk()->where(['id' => $puid])->find();
        if (empty($parant)) $this->setQueueError('读取代理数据失败!');

        // 检查异常关系处理
        if (stripos($parant['path'], "-{$user['id']}-")) {
            $this->setQueueError('不能把下级设置为代理!');
        }

        // 更新自己的代理关系
        $path1 = rtrim($parant['path'] ?: '-', '-') . "-{$parant['id']}-";
        DataUser::mk()->where(['id' => $user['id']])->update([
            'path' => $path1, 'layer' => substr_count($path1, '-'),
            'pid0' => $parant['id'], 'pid1' => $parant['id'], 'pid2' => $parant['pid1'],
        ]);
        UserUpgradeService::upgrade($user['id'], true);
        $this->setQueueMessage(1, 1, "更新指定用户[{$user['id']}]代理绑定成功!");

        // 更新下级的代理关系
        $path2 = "{$user['path']}{$user['id']}-";
        [$total, $count] = [DataUser::mk()->whereLike('path', "{$path2}%")->count(), 0];
        foreach (DataUser::mk()->whereLike('path', "{$path2}%")->order('layer desc')->select() as $vo) {
            $this->setQueueMessage($total, ++$count, "开始更新下级用户[{$vo['id']}]代理绑定!");
            // 更新下级用户代理数据
            $path3 = preg_replace("#^{$path2}#", "{$path1}{$user['id']}-", $vo['path']);
            $attrs = array_reverse(str2arr($path3, '-'));
            DataUser::mk()->where(['id' => $vo['id']])->update([
                'path' => $path3, 'layer' => substr_count($path3, '-'),
                'pid0' => $attrs[0] ?? 0, 'pid1' => $attrs[0] ?? 0, 'pid2' => $attrs[1] ?? 0,
            ]);
            $this->setQueueMessage($total, $count, "完成更新下级用户[{$vo['id']}]代理绑定!", 1);
        }
    }
}