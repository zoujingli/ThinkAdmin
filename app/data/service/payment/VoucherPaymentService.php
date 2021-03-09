<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;

/**
 * 凭证单据支付
 * Class VoucherPaymentService
 * @package app\data\service\payment
 */
class VoucherPaymentService extends PaymentService
{
    /**
     * @param string $orderNo
     * @return array
     */
    public function query(string $orderNo): array
    {
        // TODO: Implement query() method.
    }

    /**
     * @return string
     */
    public function notify(): string
    {
        // TODO: Implement notify() method.
    }

    /**
     * @param string $openid
     * @param string $orderNo
     * @param string $paymentAmount
     * @param string $paymentTitle
     * @param string $paymentRemark
     * @param string $paymentReturn
     * @return array
     */
    public function create(string $openid, string $orderNo, string $paymentAmount, string $paymentTitle, string $paymentRemark, string $paymentReturn = ''): array
    {
        // TODO: Implement create() method.
    }
}