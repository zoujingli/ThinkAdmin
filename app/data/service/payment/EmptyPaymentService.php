<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use think\admin\Exception;
use think\admin\extend\CodeExtend;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 空支付支付
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
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function create(string $openid, string $orderNo, string $paymentAmount, string $paymentTitle, string $paymentRemark, string $paymentReturn = '', string $paymentImage = ''): array
    {
        $order = $this->app->db->name('ShopOrder')->where(['order_no' => $orderNo])->find();
        if (empty($order)) throw new Exception("订单不存在");
        if ($order['status'] !== 2) throw new Exception("不可发起支付");
        // 创建支付行为
        $this->createPaymentAction($orderNo, $paymentTitle, $paymentAmount);
        // 更新支付行为
        $this->updatePaymentAction($orderNo, CodeExtend::uniqidDate(20), $paymentAmount, '无需支付');
        return ['code' => 1, 'info' => '订单无需支付'];
    }
}