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
     * 创建微信支付订单
     * @param string $openid 会员OPENID
     * @param string $orderNo 交易订单单号
     * @param string $payAmount 交易订单金额（元）
     * @param string $payTitle 交易订单名称
     * @param string $payRemark 订单订单描述
     * @param string $returnUrl 支付回跳地址
     * @return array
     * @throws \think\Exception
     */
    public function create(string $openid, string $orderNo, string $payAmount, string $payTitle, string $payRemark, string $returnUrl = ''): array
    {
        try {
            if (isset(static::TYPES[static::$type])) {
                $tradeType = static::TYPES[static::$type]['type'];
                $tradeParam = static::$type . '-' . static::$id;
            } else {
                throw new \think\Exception('支付类型[' . static::$type . ']未配置定义！');
            }
            $body = empty($payRemark) ? $payTitle : ($payTitle . '-' . $payRemark);
            $data = [
                'body'             => $body,
                'openid'           => $openid,
                'attach'           => $tradeParam,
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
                $this->createPaymentAction($tradeParam, $orderNo, $payTitle, $payAmount);
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
     * 查询微信支付订单
     * @param string $orderNo 订单单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function query(string $orderNo): array
    {
        $result = $this->payment->query(['out_trade_no' => $orderNo]);
        if (isset($result['return_code']) && isset($result['result_code']) && isset($result['attach'])) {
            if ($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS') {
                $this->updatePaymentAction($result['attach'], $result['out_trade_no'], $result['cash_fee'] / 100, $result['transaction_id']);
            }
        }
        return $result;
    }

    /**
     * 支付结果处理
     * @param string $param 支付通道
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function notify(string $param = ''): string
    {
        $notify = $this->payment->getNotify();
        if ($notify['result_code'] == 'SUCCESS' && $notify['return_code'] == 'SUCCESS') {
            if ($this->updatePaymentAction($param, $notify['out_trade_no'], $notify['transaction_id'], $notify['cash_fee'] / 100)) {
                return $this->payment->getNotifySuccessReply();
            } else {
                return 'error';
            }
        } else {
            return $this->payment->getNotifySuccessReply();
        }
    }
}