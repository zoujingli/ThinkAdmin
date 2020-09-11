<?php

namespace app\data\controller\api;

use app\data\service\OrderService;
use app\wechat\service\WechatService;
use think\admin\Controller;

/**
 * 异步通知处理
 * Class Notify
 * @package app\data\controller\api
 */
class Notify extends Controller
{
    /**
     * 微信支付通知处理
     * @param string $scene 支付场景
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function wxpay($scene = 'order')
    {
        $notify = ($payment = WechatService::WePayOrder())->getNotify();
        if ($notify['result_code'] == 'SUCCESS' && $notify['return_code'] == 'SUCCESS') {
            if ($scene === 'order') {
                if ($this->setOrder($notify['out_trade_no'], $notify['cash_fee'] / 100, $notify['transaction_id'], 'wxpay')) {
                    return $payment->getNotifySuccessReply();
                }
            }
            // ... 其他支付场景
        }
        return $payment->getNotifySuccessReply();
    }

    /**
     * 订单状态更新
     * @param string $code 订单单号
     * @param string $amount 交易金额
     * @param string $paycode 交易单号
     * @param string $paytype 支付类型
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function setOrder($code, $amount, $paycode, $paytype = 'wxpay')
    {
        // 检查订单支付状态
        $map = ['order_no' => $code, 'payment_status' => 0, 'status' => 2];
        $order = $this->app->db->name('StoreOrder')->where($map)->find();
        if (empty($order)) return false;
        // 更新订单支付状态
        $this->app->db->name('StoreOrder')->where($map)->update([
            'status'           => 3,
            'payment_type'     => $paytype,
            'payment_code'     => $paycode,
            'payment_status'   => 1,
            'payment_amount'   => $amount,
            'payment_remark'   => '微信在线支付',
            'payment_datetime' => date('Y-m-d H:i:s'),
        ]);
        // 调用会员升级机制
        return OrderService::instance()->syncAmount($order['order_no']);
    }
}