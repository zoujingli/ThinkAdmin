<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace app\wechat\command;

use app\wechat\model\WechatPaymentRecord;
use think\admin\Command;
use think\console\Input;
use think\console\Output;

/**
 * 微信支付单清理任务
 * @class Clear
 * @package app\wechat\command
 */
class Clear extends Command
{
    protected function configure()
    {
        $this->setName('xadmin:fanspay');
        $this->setDescription('Wechat Users Payment auto clear for ThinkAdmin');
    }

    /**
     * 执行支付单清理任务
     * @param \think\console\Input $input
     * @param \think\console\Output $output
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DbException
     */
    protected function execute(Input $input, Output $output)
    {
        $query = WechatPaymentRecord::mq();
        $query->where(['payment_status' => 0]);
        $query->whereTime('create_time', '<', strtotime('-24 hours'));
        [$total, $count] = [(clone $query)->count(), 0];
        if (empty($total)) $this->setQueueSuccess('无需清理24小时未支付！');
        /** @var \think\Model $item */
        foreach ($query->cursor() as $item) {
            $this->setQueueMessage($total, ++$count, sprintf('开始清理 %s 支付单...', $item->getAttr('code')));
            $item->delete();
            $this->setQueueMessage($total, $count, sprintf('完成清理 %s 支付单！', $item->getAttr('code')), 1);
        }
    }
}