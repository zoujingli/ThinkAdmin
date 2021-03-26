<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use think\admin\Exception;

/**
 * 支付宝支付基础服务
 * Class AlipayPaymentService
 * @package app\store\service\payment
 */
class AlipayPaymentService extends PaymentService
{

    /**
     * 支付参数配置
     * @var array
     */
    protected $config = [];

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
            $this->config['notify_url'] = sysuri("@data/api.notify/alipay/scene/order/param/{$this->code}", [], false, true);
            if (in_array($tradeType, [static::PAYMENT_ALIPAY_WAP, static::PAYMENT_ALIPAY_WEB])) {
                if (empty($paymentReturn)) {
                    throw new Exception('支付回跳地址不能为空！');
                } else {
                    $this->config['return_url'] = $paymentReturn;
                }
            }
            if ($tradeType === static::PAYMENT_WECHAT_APP) {
                $payment = \AliPay\App::instance($this->config);
            } elseif ($tradeType === static::PAYMENT_ALIPAY_WAP) {
                $payment = \AliPay\Wap::instance($this->config);
            } elseif ($tradeType === static::PAYMENT_ALIPAY_WEB) {
                $payment = \AliPay\Web::instance($this->config);
            } else {
                throw new Exception("支付类型[{$tradeType}]暂时不支持！");
            }
            $data = ['out_trade_no' => $orderNo, 'total_amount' => $paymentAmount, 'subject' => $paymentTitle];
            if (!empty($paymentRemark)) $data['body'] = $paymentRemark;
            $result = $payment->apply($data);
            // 创建支付记录
            $this->createPaymentAction($orderNo, $paymentTitle, $paymentAmount);
            // 返回支付参数
            return ['result' => $result];
        } catch (Exception $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
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
        $notify = \AliPay\App::instance($this->config)->notify();
        if (in_array($notify['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
            if ($this->updatePaymentAction($notify['out_trade_no'], $notify['trade_no'], $notify['total_amount'])) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'success';
        }
    }

    /**
     * 查询订单数据
     * @param string $orderNo
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function query(string $orderNo): array
    {
        return \AliPay\App::instance($this->config)->query($orderNo);
    }

    /**
     * 支付服务初始化
     * @return $this
     */
    protected function initialize(): AlipayPaymentService
    {
        $this->config = [
            // 沙箱模式
            'debug'       => false,
            // 签名类型（RSA|RSA2）
            'sign_type'   => "RSA2",
            // 应用ID
            'appid'       => $this->params['alipay_appid'],
            // 支付宝公钥 (1行填写，特别注意，这里是支付宝公钥，不是应用公钥，最好从开发者中心的网页上去复制)
            'public_key'  => $this->_trimCertHeader($this->params['alipay_public_key']),
            // 支付宝私钥 (1行填写)
            'private_key' => $this->_trimCertHeader($this->params['alipay_private_key']),
            // 支付成功通知地址
            'notify_url'  => '',
            // 网页支付回跳地址
            'return_url'  => '',
        ];
        return $this;
    }

    /**
     * 去除证书内容前后缀
     * @param string $content
     * @return string
     */
    private function _trimCertHeader(string $content): string
    {
        return preg_replace(['/\s+/', '/-{5}.*?-{5}/'], '', $content);
    }
}