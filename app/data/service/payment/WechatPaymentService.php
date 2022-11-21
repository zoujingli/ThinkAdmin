<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use think\admin\Exception;
use WePay\Order as OrderV2;
use WePayV3\Order as OrderV3;

/**
 * 微信官方公众号支持
 * Class WechatPaymentService
 * @package app\data\service\payment
 */
class WechatPaymentService extends PaymentService
{
    /**
     * 微信对象对象
     * @var OrderV2|OrderV3
     */
    protected $payment;

    /**
     * 支付接口版本
     * @var string
     */
    protected $version;


    /**
     * 微信支付服务初始化
     * @return WechatPaymentService
     */
    protected function initialize(): WechatPaymentService
    {
        $this->version = $this->params['wechat_type'] ?? 'v2';
        if ($this->version === 'v2') {
            $this->payment = OrderV2::instance([
                'appid'      => $this->params['wechat_appid'],
                'mch_id'     => $this->params['wechat_mch_id'],
                'mch_key'    => $this->params['wechat_mch_key'],
                'cache_path' => with_path('runtime/wechat'),
            ]);
        } else {
            $this->payment = OrderV3::instance([
                'appid'        => $this->params['wechat_appid'],
                'mch_id'       => $this->params['wechat_mch_id'],
                'mch_v3_key'   => $this->params['wechat_mch_v3_key'],
                'cert_public'  => $this->params['wechat_mch_v3_public'],
                'cert_private' => $this->params['wechat_mch_v3_private'],
                'cache_path'   => with_path('runtime/wechat'),
            ]);
        }
        return $this;
    }

    /**
     * 创建订单支付参数
     * @param string $openid 用户OPENID
     * @param string $orderNo 交易订单单号
     * @param string $payAmount 交易订单金额（元）
     * @param string $payTitle 交易订单名称
     * @param string $payRemark 订单订单描述
     * @param string $payReturn 完成回跳地址
     * @param string $payImage 支付凭证图片
     * @return array
     * @throws Exception
     */
    public function create(string $openid, string $orderNo, string $payAmount, string $payTitle, string $payRemark, string $payReturn = '', string $payImage = ''): array
    {
        try {
            if (empty(static::TYPES[$this->type])) {
                throw new Exception(sprintf('支付类型[%s]未配置定义！', $this->type));
            }
            $body = empty($payRemark) ? $payTitle : ($payTitle . '-' . $payRemark);
            $notify = sysuri("@data/api.notify/wxpay/scene/order/param/{$this->code}", [], false, true);
            if ($this->version === 'v2') {
                $dataV2 = [
                    'body'             => $body,
                    'openid'           => $openid,
                    'attach'           => $this->code,
                    'out_trade_no'     => $orderNo,
                    'total_fee'        => $payAmount * 100,
                    'trade_type'       => static::TYPES[$this->type]['type'] ?? '',
                    'notify_url'       => $notify,
                    'spbill_create_ip' => $this->app->request->ip(),
                ];
                if (empty($openid)) unset($dataV2['openid']);
                $info = $this->payment->create($dataV2);
            } else {
                $dataV3 = [
                    'appid'        => $this->params['wechat_appid'],
                    'mchid'        => $this->params['wechat_mch_id'],
                    'payer'        => ['openid' => $openid],
                    'amount'       => ['total' => $payAmount * 100, 'currency' => 'CNY'],
                    'out_trade_no' => $orderNo,
                    'notify_url'   => $notify,
                    'description'  => $body,
                ];
                if (empty($openid)) unset($dataV3['payer']);
                $info = $this->payment->create(strtolower(static::TYPES[$this->type]['type']), $dataV3);
            }
            if ($info['return_code'] === 'SUCCESS' && $info['result_code'] === 'SUCCESS') {
                // 创建支付记录
                $this->createPaymentAction($orderNo, $payTitle, $payAmount);
                // 微信二维码及网页支付
                if (in_array($this->type, [static::PAYMENT_WECHAT_WAP, static::PAYMENT_WECHAT_QRC])) {
                    return $info;
                }
                // 返回JSAPI参数
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
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function notify(): string
    {
        $data = [];
        if ($this->version === 'v3') {
            $notify = $this->payment->notify();
            if ($notify['event_type'] === 'TRANSACTION.SUCCESS') {
                $data['cash_fee'] = $notify['result']['amount']['total'] ?? 0;
                $data['result_code'] = 'SUCCESS';
                $data['return_code'] = 'SUCCESS';
                $data['out_trade_no'] = $notify['result']['out_trade_no'];
                $data['transaction_id'] = $notify['result']['transaction_id'];
            } else {
                $data['result_code'] = $notify['event_type'] ?? 'ERROR';
            }
        } else {
            $notify = $this->payment->getNotify();
            $data['cash_fee'] = $notify['cash_fee'];
            $data['result_code'] = $notify['result_code'];
            $data['return_code'] = $notify['return_code'];
            $data['out_trade_no'] = $notify['out_trade_no'];
            $data['transaction_id'] = $notify['transaction_id'];
        }
        // 更新订单支付信息
        if ($data['result_code'] == 'SUCCESS' && $data['return_code'] == 'SUCCESS') {
            if ($this->updatePaymentAction($data['out_trade_no'], $data['transaction_id'], $data['cash_fee'] / 100)) {
                return $this->payment->getNotifySuccessReply();
            } else {
                return 'error';
            }
        } else {
            return $this->payment->getNotifySuccessReply();
        }
    }
}