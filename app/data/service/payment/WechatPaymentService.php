<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
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
     * @param string $payRemark 订单订单描述
     * @return array
     * @throws \think\Exception
     */
    public function create(string $openid, string $orderNo, string $payAmount, string $payTitle, string $payRemark): array
    {
        try {
            if (isset(static::TYPES[static::$type])) {
                $tradeType = static::TYPES[static::$type]['type'];
                $tradeParam = static::$type . '_' . static::$id;
            } else {
                throw new \think\Exception('支付类型[' . static::$type . ']未配置定义！');
            }
            $body = empty($payRemark) ? $payTitle : ($payTitle . '-' . $payRemark);
            $data = [
                'body'             => $body,
                'openid'           => $openid,
                'out_trade_no'     => $orderNo,
                'total_fee'        => $payAmount * 100,
                'trade_type'       => $tradeType ?: '',
                'notify_url'       => sysuri("@data/api.notify/wxpay/scene/order/param/{$tradeParam}", [], false, true),
                'spbill_create_ip' => $this->app->request->ip(),
            ];
            if (empty($data['openid'])) unset($data['openid']);
            $info = $this->payment->create($data);
            if ($info['return_code'] === 'SUCCESS' && $info['result_code'] === 'SUCCESS') {
                // 创建支付记录
                $this->app->db->name('DataPaymentItem')->insert([
                    'order_no'   => $orderNo, 'order_name' => $payTitle, 'order_amount' => $payAmount,
                    'payment_id' => static::$id, 'payment_type' => static::$type,
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
     * @param string $type 支付通道
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function notify(string $type = ''): string
    {
        if (is_numeric(stripos($type, '_'))) {
            [$payType, $payId] = explode('_', $type);
        } else {
            [$payType, $payId] = [$type ?: static::$type, static::$id];
        }
        $notify = $this->payment->getNotify();
        if ($notify['result_code'] == 'SUCCESS' && $notify['return_code'] == 'SUCCESS') {
            // 更新支付记录
            data_save('DataPaymentItem', [
                'order_no'         => $notify['out_trade_no'],
                'payment_id'       => $payId,
                'payment_type'     => $payType,
                'payment_code'     => $notify['transaction_id'],
                'payment_amount'   => $notify['cash_fee'] / 100,
                'payment_status'   => 1,
                'payment_datatime' => date('Y-m-d H:i:s'),
            ], 'order_no', ['payment_type' => $payType, 'payment_status' => 0]);
            // 更新记录状态
            if ($this->updateOrder($notify['out_trade_no'], $notify['transaction_id'], $notify['cash_fee'] / 100, $payType)) {
                return $this->payment->getNotifySuccessReply();
            }
        } else {
            return $this->payment->getNotifySuccessReply();
        }
    }
}