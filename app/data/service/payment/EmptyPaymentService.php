<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use think\admin\extend\CodeExtend;
use think\admin\Exception;

/**
 * 空支付通道
 * Class EmptyPaymentService
 * @package app\data\service\payment
 */
class EmptyPaymentService extends PaymentService
{

    /**
     * 订单主动查询
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
        return '';
    }

    /**
     * 创建支付订单
     * @param string $openid 用户OPENID
     * @param string $orderNo 交易订单单号
     * @param string $paymentAmount 交易订单金额（元）
     * @param string $paymentTitle 交易订单名称
     * @param string $paymentRemark 交易订单描述
     * @param string $paymentReturn 支付回跳地址
     * @return array
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function create(string $openid, string $orderNo, string $paymentAmount, string $paymentTitle, string $paymentRemark, string $paymentReturn = ''): array
    {
        $order = $this->app->db->name('ShopOrder')->where(['order_no' => $orderNo])->find();
        if (empty($order)) throw new Exception("订单不存在");
        if ($order['status'] !== 2) throw new Exception("不可发起支付");
        // 创建支付行为
        $this->createPaymentAction($orderNo, $paymentTitle, $paymentAmount);
        // 更新支付行为
        $this->updatePaymentAction($orderNo, CodeExtend::uniqidDate(20), $paymentAmount, '无需支付');
        return ['info' => '无需支付'];
    }
}