<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use think\admin\Exception;
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
     */
    public function create(string $openid, string $orderNo, string $paymentAmount, string $paymentTitle, string $paymentRemark, string $paymentReturn = '', string $paymentImage = ''): array
    {
        try {
            if (isset(static::TYPES[$this->type])) {
                $tradeType = static::TYPES[$this->type]['type'];
            } else {
                throw new Exception(sprintf('支付类型[%s]未配置定义！', $this->type));
            }
            $body = empty($paymentRemark) ? $paymentTitle : ($paymentTitle . '-' . $paymentRemark);
            $data = [
                'body'             => $body,
                'openid'           => $openid,
                'attach'           => $this->code,
                'out_trade_no'     => $orderNo,
                'trade_type'       => $tradeType ?: '',
                'total_fee'        => $paymentAmount * 100,
                'notify_url'       => sysuri("@data/api.notify/wxpay/scene/order/param/{$this->code}", [], false, true),
                'spbill_create_ip' => $this->app->request->ip(),
            ];
            if (empty($data['openid'])) unset($data['openid']);
            $info = $this->payment->create($data);
            if ($info['return_code'] === 'SUCCESS' && $info['result_code'] === 'SUCCESS') {
                // 创建支付记录
                $this->createPaymentAction($orderNo, $paymentTitle, $paymentAmount);
                // 返回支付参数
                return $this->payment->jsapiParams($info['prepay_id']);
            }
            throw new Exception($info['err_code_des'] ?? '获取预支付码失败！');
        } catch (Exception $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
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
                $this->updatePaymentAction($result['out_trade_no'], $result['cash_fee'] / 100, $result['transaction_id']);
            }
        }
        return $result;
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
            if ($this->updatePaymentAction($notify['out_trade_no'], $notify['transaction_id'], $notify['cash_fee'] / 100)) {
                return $this->payment->getNotifySuccessReply();
            } else {
                return 'error';
            }
        } else {
            return $this->payment->getNotifySuccessReply();
        }
    }

    /**
     * 微信支付服务初始化
     * @return WechatPaymentService
     */
    protected function initialize(): WechatPaymentService
    {
        $this->payment = Order::instance([
            'appid'      => $this->params['wechat_appid'],
            'mch_id'     => $this->params['wechat_mch_id'],
            'mch_key'    => $this->params['wechat_mch_key'],
            'cache_path' => $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . 'wechat',
        ]);
        return $this;
    }
}