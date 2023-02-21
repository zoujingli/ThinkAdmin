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

namespace app\data\service\payment;

use app\data\model\DataUserBalance;
use app\data\model\ShopOrder;
use app\data\service\PaymentService;
use app\data\service\UserBalanceService;
use think\admin\Exception;
use think\admin\extend\CodeExtend;

/**
 * 账号余额支付参数处理
 * Class BalancePaymentService
 * @package app\data\service\payment
 */
class BalancePaymentService extends PaymentService
{
    /**
     * 订单信息查询
     * @param string $orderNo
     * @return array
     */
    public function query(string $orderNo): array
    {
        return [];
    }

    /**
     * 支付通知处理
     * @return string
     */
    public function notify(): string
    {
        return 'SUCCESS';
    }

    /**
     * 创建订单支付参数
     * @param string $openid 用户OPENID
     * @param string $orderNo 交易订单单号
     * @param string $payAmount 交易订单金额（元）
     * @param string $payTitle 交易订单名称
     * @param string $payRemark 订单订单描述
     * @param string $payReturn 完成回跳地址
     * @param string $payImage 支付凭证图片
     * @return array
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function create(string $openid, string $orderNo, string $payAmount, string $payTitle, string $payRemark, string $payReturn = '', string $payImage = ''): array
    {
        $order = ShopOrder::mk()->where(['order_no' => $orderNo])->find();
        if (empty($order)) throw new Exception("订单不存在");
        if ($order['status'] !== 2) throw new Exception("不可发起支付");
        // 创建支付行为
        $this->createPaymentAction($orderNo, $payTitle, $payAmount);
        // 检查能否支付
        [$total, $count] = UserBalanceService::amount($order['uuid'], [$orderNo]);
        if ($payAmount > $total - $count) throw new Exception("可抵扣余额不足");
        try {
            // 扣减用户余额
            $this->app->db->transaction(function () use ($order, $payAmount) {
                // 更新订单余额
                ShopOrder::mk()->where(['order_no' => $order['order_no']])->update([
                    'payment_balance' => $payAmount,
                ]);
                // 扣除余额金额
                DataUserBalance::mUpdate([
                    'uuid'   => $order['uuid'],
                    'code'   => "KC{$order['order_no']}",
                    'name'   => "账户余额支付",
                    'remark' => "支付订单 {$order['order_no']} 的扣除余额 {$payAmount} 元",
                    'amount' => -$payAmount,
                ], 'code');
                // 更新支付行为
                $this->updatePaymentAction($order['order_no'], CodeExtend::uniqidDate(20), $payAmount, '账户余额支付');
            });
            // 刷新用户余额
            UserBalanceService::amount($order['uuid']);
            return ['code' => 1, 'info' => '余额支付完成'];
        } catch (\Exception $exception) {
            return ['code' => 0, 'info' => $exception->getMessage()];
        }
    }
}