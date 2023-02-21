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

namespace app\data\service;

use app\data\model\DataUser;
use app\data\model\DataUserBalance;
use app\data\model\ShopOrder;
use think\admin\Exception;
use think\admin\Service;

/**
 * 用户余额数据服务
 * Class UserBalanceService
 * @package app\data\service
 */
class UserBalanceService extends Service
{

    /**
     * 验证订单发放余额
     * @param string $orderNo
     * @return array [total, count]
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function confirm(string $orderNo): array
    {
        $order = ShopOrder::mk()->where([['status', '>=', 4], ['order_no', '=', $orderNo]])->find();
        if (empty($order)) throw new Exception('需处理的订单状态异常');

        if ($order['reward_balance'] > 0) DataUserBalance::mUpdate([
            'uuid'   => $order['uuid'],
            'code'   => "CZ{$order['order_no']}",
            'name'   => "订单余额充值",
            'remark' => "来自订单 {$order['order_no']} 的余额充值 {$order['reward_balance']} 元",
            'amount' => $order['reward_balance'],
        ], 'code');

        return static::amount($order['uuid']);
    }

    /**
     * 同步刷新用户余额
     * @param int $uuid 用户UID
     * @param array $nots 排除的订单
     * @return array [total, count]
     */
    public static function amount(int $uuid, array $nots = []): array
    {
        if ($uuid > 0) {
            $total = abs(DataUserBalance::mk()->whereRaw("uuid='{$uuid}' and amount>0 and deleted=0")->sum('amount'));
            $count = abs(DataUserBalance::mk()->whereRaw("uuid='{$uuid}' and amount<0 and deleted=0")->sum('amount'));
            if (empty($nots)) {
                DataUser::mk()->where(['id' => $uuid])->update(['balance_total' => $total, 'balance_used' => $count]);
            } else {
                $count -= DataUserBalance::mk()->whereRaw("uuid={$uuid}")->whereIn('code', $nots)->sum('amount');
            }
        } else {
            $total = abs(DataUserBalance::mk()->whereRaw("amount>0 and deleted=0")->sum('amount'));
            $count = abs(DataUserBalance::mk()->whereRaw("amount<0 and deleted=0")->sum('amount'));
        }
        return [$total, $count];
    }
}