<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use app\data\service\UserBalanceService;
use think\admin\Exception;
use think\admin\extend\CodeExtend;

/**
 * 账号余额支付参数处理
 * Class BalancePyamentService
 * @package app\data\service\payment
 */
class BalancePyamentService extends PaymentService
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
     * @param string $paymentAmount 交易订单金额（元）
     * @param string $paymentTitle 交易订单名称
     * @param string $paymentRemark 订单订单描述
     * @param string $paymentReturn 完成回跳地址
     * @param string $paymentImage 支付凭证图片
     * @return array
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function create(string $openid, string $orderNo, string $paymentAmount, string $paymentTitle, string $paymentRemark, string $paymentReturn = '', string $paymentImage = ''): array
    {
        $order = $this->app->db->name('ShopOrder')->where(['order_no' => $orderNo])->find();
        if (empty($order)) throw new Exception("订单不存在");
        if ($order['status'] !== 2) throw new Exception("不可发起支付");
        // 创建支付行为
        $this->createPaymentAction($orderNo, $paymentTitle, $paymentAmount);
        // 检查能否支付
        [$total, $count] = UserBalanceService::instance()->amount($order['uid'], [$orderNo]);
        if ($paymentAmount > $total - $count) throw new Exception("可抵扣余额不足");
        try {
            // 扣减用户余额
            $this->app->db->transaction(function () use ($order, $paymentAmount) {
                // 更新订单余额
                $this->app->db->name('ShopOrder')->where(['order_no' => $order['order_no']])->update([
                    'payment_balance' => $paymentAmount,
                ]);
                // 扣除余额金额
                data_save('DataUserBalance', [
                    'uid'    => $order['uid'],
                    'code'   => "KC{$order['order_no']}",
                    'name'   => "账户余额支付",
                    'remark' => "支付订单 {$order['order_no']} 的扣除余额 {$paymentAmount} 元",
                    'amount' => -$paymentAmount,
                ], 'code');
                // 更新支付行为
                $this->updatePaymentAction($order['order_no'], CodeExtend::uniqidDate(20), $paymentAmount, '账户余额支付');
            });
            // 刷新用户余额
            UserBalanceService::instance()->amount($order['uid']);
            return ['code' => 1, 'info' => '余额支付完成'];
        } catch (\Exception $exception) {
            return ['code' => 0, 'info' => $exception->getMessage()];
        }
    }
}