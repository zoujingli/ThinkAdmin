<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use think\admin\Exception;
use think\admin\extend\CodeExtend;

/**
 * 凭证单据支付
 * Class VoucherPaymentService
 * @package app\data\service\payment
 */
class VoucherPaymentService extends PaymentService
{
    /**
     * 订单数据查询
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
        return 'success';
    }

    /**
     * @param string $openid
     * @param string $orderNo
     * @param string $paymentAmount
     * @param string $paymentTitle
     * @param string $paymentRemark
     * @param string $paymentReturn
     * @return array
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function create(string $openid, string $orderNo, string $paymentAmount, string $paymentTitle, string $paymentRemark, string $paymentReturn = ''): array
    {
        //  @todo 支付凭证需要再处理下
        $order = $this->app->db->name('ShopOrder')->where(['order_no' => $orderNo])->find();
        if (empty($order)) throw new Exception("订单不存在");
        if ($order['status'] !== 2) throw new Exception("不可发起支付");
        $this->updateOrder($orderNo, CodeExtend::uniqidDate(20), $paymentAmount, '支付凭证');
        return ['info' => '支付凭证上传成功！', 'status' => 1];
    }
}