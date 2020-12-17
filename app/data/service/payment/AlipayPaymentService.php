<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;

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
    protected $params = [];

    /**
     * 支付服务初始化
     * @return $this
     */
    protected function initialize(): AlipayPaymentService
    {
        $this->params = [
            // 沙箱模式
            'debug'       => false,
            // 签名类型（RSA|RSA2）
            'sign_type'   => "RSA2",
            // 应用ID
            'appid'       => static::$config['alipay_appid'],
            // 支付宝公钥 (1行填写，特别注意，这里是支付宝公钥，不是应用公钥，最好从开发者中心的网页上去复制)
            'public_key'  => $this->_trimCertHeader(static::$config['alipay_public_key']),
            // 支付宝私钥 (1行填写)
            'private_key' => $this->_trimCertHeader(static::$config['alipay_private_key']),
            // 应用公钥证书（新版资金类接口转 app_cert_sn）
            # 'app_cert'    => '',
            // 支付宝根证书（新版资金类接口转 alipay_root_cert_sn）
            # 'root_cert'   => '',
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
        $notify = \AliPay\App::instance($this->params)->notify();
        if (in_array($notify['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
            if ($this->updatePaymentAction($param, $notify['out_trade_no'], $notify['trade_no'], $notify['total_amount'])) {
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
        return \AliPay\App::instance($this->params)->query($orderNo);
    }

    /**
     * 创建订单支付参数
     * @param string $openid 会员OPENID
     * @param string $orderNo 交易订单单号
     * @param string $payAmount 交易订单金额（元）
     * @param string $payTitle 交易订单名称
     * @param string $payRemark 订单订单描述
     * @param string $returnUrl 完成回跳地址
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
            $this->params['notify_url'] = sysuri("@data/api.notify/alipay/scene/order/param/{$tradeParam}", [], false, true);
            if (in_array($tradeType, [static::PAYMENT_ALIPAY_WAP, static::PAYMENT_ALIPAY_WEB])) {
                if (empty($returnUrl)) {
                    throw new \think\Exception('支付回跳地址不能为空！');
                } else {
                    $this->params['return_url'] = $returnUrl;
                }
            }
            if ($tradeType === static::PAYMENT_WECHAT_APP) {
                $payment = \AliPay\App::instance($this->params);
            } elseif ($tradeType === static::PAYMENT_ALIPAY_WAP) {
                $payment = \AliPay\Wap::instance($this->params);
            } elseif ($tradeType === static::PAYMENT_ALIPAY_WEB) {
                $payment = \AliPay\Web::instance($this->params);
            } else {
                throw new \think\Exception("支付类型[{$tradeType}]暂时不支持！");
            }
            $data = ['out_trade_no' => $orderNo, 'total_amount' => $payAmount, 'subject' => $payTitle];
            if (!empty($payRemark)) $data['body'] = $payRemark;
            $result = $payment->apply($data);
            // 创建支付记录
            $this->createPaymentAction($tradeParam, $orderNo, $payTitle, $payAmount);
            // 返回支付参数
            return ['result' => $result];
        } catch (\think\Exception $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new \think\Exception($exception->getMessage(), $exception->getCode());
        }
    }
}