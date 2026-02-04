<?php

declare(strict_types=1);
/**
 * +----------------------------------------------------------------------
 * | ThinkAdmin Plugin for ThinkAdmin
 * +----------------------------------------------------------------------
 * | 版权所有 2014~2026 ThinkAdmin [ thinkadmin.top ]
 * +----------------------------------------------------------------------
 * | 官方网站: https://thinkadmin.top
 * +----------------------------------------------------------------------
 * | 开源协议 ( https://mit-license.org )
 * | 免责声明 ( https://thinkadmin.top/disclaimer )
 * | 会员特权 ( https://thinkadmin.top/vip-introduce )
 * +----------------------------------------------------------------------
 * | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
 * | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
 * +----------------------------------------------------------------------
 */

namespace app\wechat\command;

use app\wechat\model\WechatPaymentRecord;
use think\admin\Command;
use think\admin\Exception;
use think\console\Input;
use think\console\Output;
use think\db\exception\DbException;
use think\Model;

/**
 * 微信支付单清理任务
 * @class Clear
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
     * @throws Exception
     * @throws DbException
     */
    protected function execute(Input $input, Output $output)
    {
        $query = WechatPaymentRecord::mq();
        $query->where(['payment_status' => 0]);
        $query->whereTime('create_time', '<', strtotime('-24 hours'));
        [$total, $count] = [(clone $query)->count(), 0];
        if (empty($total)) {
            $this->setQueueSuccess('无需清理24小时未支付！');
        }
        /** @var Model $item */
        foreach ($query->cursor() as $item) {
            $this->setQueueMessage($total, ++$count, sprintf('开始清理 %s 支付单...', $item->getAttr('code')));
            $item->delete();
            $this->setQueueMessage($total, $count, sprintf('完成清理 %s 支付单！', $item->getAttr('code')), 1);
        }
    }
}
