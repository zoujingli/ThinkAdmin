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
use app\data\model\DataUserRebate;
use app\data\model\DataUserTransfer;
use app\data\model\ShopOrder;
use think\admin\Service;

/**
 * 用户返利数据服务
 * Class UserRebateService
 * @package app\data\service
 */
class UserRebateService extends Service
{
    /**
     * 同步刷新用户返利
     * @param integer $uuid
     * @return array [total, count, lock]
     * @throws \think\db\exception\DbException
     */
    public static function amount(int $uuid): array
    {
        if ($uuid > 0) {
            $count = DataUserTransfer::mk()->whereRaw("uuid='{$uuid}' and status>0")->sum('amount');
            $total = DataUserRebate::mk()->whereRaw("uuid='{$uuid}' and status=1 and deleted=0")->sum('amount');
            $locks = DataUserRebate::mk()->whereRaw("uuid='{$uuid}' and status=0 and deleted=0")->sum('amount');
            DataUser::mk()->where(['id' => $uuid])->update(['rebate_total' => $total, 'rebate_used' => $count, 'rebate_lock' => $locks]);
        } else {
            $count = DataUserTransfer::mk()->whereRaw("status>0")->sum('amount');
            $total = DataUserRebate::mk()->whereRaw("status=1 and deleted=0")->sum('amount');
            $locks = DataUserRebate::mk()->whereRaw("status=0 and deleted=0")->sum('amount');
        }
        return [$total, $count, $locks];
    }

    /**
     * 确认收货订单处理
     * @param string $orderNo
     * @return array [status, message]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function confirm(string $orderNo): array
    {
        $map = [['status', '>=', 4], ['order_no', '=', $orderNo]];
        $order = ShopOrder::mk()->where($map)->findOrEmpty()->toArray();
        if (empty($order)) return [0, '需处理的订单状态异常！'];
        $map = [['status', '=', 0], ['order_no', 'like', "{$orderNo}%"]];
        DataUserRebate::mk()->where($map)->update(['status' => 1]);
        if (UserUpgradeService::upgrade($order['uuid'])) {
            return [1, '重新计算用户金额成功！'];
        } else {
            return [0, '重新计算用户金额失败！'];
        }
    }
}