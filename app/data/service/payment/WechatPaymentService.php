<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use http\Exception;
use WePay\Order;

/**
 * 微信官方公众号支持
 * Class WechatPaymentService
 * @package app\store\service\payment
 */
class WechatPaymentService extends PaymentService
{
    /**
     * 微信对象对象
     * @var Order
     */
    protected $payment;

    /**
     * 微信支付服务初始化
     * @return WechatPaymentService
     */
    protected function initialize(): WechatPaymentService
    {
        $this->payment = Order::instance([
            'appid'      => static::$config['wechat_appid'],
            'mch_id'     => static::$config['wechat_mch_id'],
            'mch_key'    => static::$config['wechat_mch_key'],
            'cache_path' => $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . 'wechat',
        ]);
        return $this;
    }

    /**
     * 查询微信支付订单
     * @param string $orderNo
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function query(string $orderNo): array
    {
        return $this->payment->query(['out_trade_no' => $orderNo]);
    }

    /**
     * 创建微信支付订单
     * @param string $openid 会员OPENID
     * @param string $orderNo 交易订单单号
     * @param string $payAmount 交易订单金额（元）
     * @param string $payTitle 交易订单名称
     * @param string $payDescription 订单订单描述
     * @return array
     * @throws \think\Exception
     */
    public function create(string $openid, string $orderNo, string $payAmount, string $payTitle, string $payDescription): array
    {
        try {
            $body = empty($payDescription) ? $payTitle : ($payTitle . '-' . $payDescription);
            $data = [
                'body'             => $body,
                'openid'           => $openid,
                'out_trade_no'     => $orderNo,
                'total_fee'        => $payAmount * 100,
                'trade_type'       => 'JSAPI',
                'notify_url'       => sysuri('@data/api.notify/wxpay/scene/order', [], false, true),
                'spbill_create_ip' => $this->app->request->ip(),
            ];
            if (empty($data['openid'])) unset($data['openid']);
            $info = $this->payment->create($data);
            if ($info['return_code'] === 'SUCCESS' && $info['result_code'] === 'SUCCESS') {
                // 创建支付记录
                $this->app->db->name('DataPaymentItem')->insert([
                    'order_no' => $orderNo, 'order_name' => $payTitle, 'order_amount' => $payAmount, 'payment_type' => static::$type,
                ]);
                // 返回支付参数
                return $this->payment->jsapiParams($info['prepay_id']);
            }
            if (isset($info['err_code_des'])) {
                throw new \think\Exception($info['err_code_des']);
            } else {
                throw new \think\Exception('获取预支付码失败！');
            }
        } catch (\think\Exception $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new \think\Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 支付结果处理
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function notify(): string
    {
        $notify = $this->payment->getNotify();
        if ($notify['result_code'] == 'SUCCESS' && $notify['return_code'] == 'SUCCESS') {
            // 更新支付记录
            data_save('DataPaymentItem', [
                'order_no'         => $notify['out_trade_no'],
                'payment_type'     => static::$type,
                'payment_code'     => $notify['transaction_id'],
                'payment_amount'   => $notify['cash_fee'] / 100,
                'payment_status'   => 1,
                'payment_datatime' => date('Y-m-d H:i:s'),
            ], 'order_no', ['payment_type' => static::$type, 'payment_status' => 0]);
            // 更新记录状态
            if ($this->updateOrder($notify['out_trade_no'], $notify['transaction_id'], $notify['cash_fee'] / 100, 'wechat')) {
                return $this->payment->getNotifySuccessReply();
            }
        } else {
            return $this->payment->getNotifySuccessReply();
        }
    }
}