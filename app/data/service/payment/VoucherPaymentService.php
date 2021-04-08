<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use think\admin\Exception;
use think\admin\extend\CodeExtend;

/**
 * 单据凭证支付
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
        if (empty($paymentImage)) throw new Exception('支付凭证不能为空');
        $this->updateOrder($orderNo, CodeExtend::uniqidDate(20), $paymentAmount, '单据凭证支付', $paymentImage);
        return ['code' => 1, 'info' => '支付凭证上传成功！'];
    }
}