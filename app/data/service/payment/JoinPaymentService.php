<?php

namespace app\data\service\payment;

use app\data\service\PaymentService;
use think\admin\extend\HttpExtend;

/**
 * 汇聚支付基础服务
 * Class JoinPaymentService
 * @package app\store\service\payment
 */
class JoinPaymentService extends PaymentService
{
    /**
     * 请求地址
     * @var string
     */
    protected $uri;

    /**
     * 应用编号
     * @var string
     */
    protected $appid;

    /**
     * 报备商户号
     * @var string
     */
    protected $trade;

    /**
     * 平台商户号
     * @var string
     */
    protected $mchid;

    /**
     * 平台商户密钥
     * @var string
     */
    protected $mchkey;

    /**
     * 汇聚支付服务初始化
     * @return JoinPaymentService
     */
    protected function initialize(): JoinPaymentService
    {
        $this->appid = $this->params['joinpay_appid'];
        $this->trade = $this->params['joinpay_trade'];;
        $this->mchid = $this->params['joinpay_mch_id'];
        $this->mchkey = $this->params['joinpay_mch_key'];
        return $this;
    }

    /**
     * 创建订单支付参数
     * @param string $openid 会员OPENID
     * @param string $orderNo 交易订单单号
     * @param string $paymentAmount 交易订单金额（元）
     * @param string $paymentTitle 交易订单名称
     * @param string $paymentRemark 订单订单描述
     * @param string $paymentReturn 支付回跳地址
     * @return array
     * @throws \think\Exception
     */
    public function create(string $openid, string $orderNo, string $paymentAmount, string $paymentTitle, string $paymentRemark, string $paymentReturn = ''): array
    {
        try {
            if (isset(static::TYPES[$this->type])) {
                $tradeType = static::TYPES[$this->type]['type'];
            } else {
                throw new \think\Exception(sprintf('支付类型[%s]未配置定义！', $this->type));
            }
            $data = [
                'p0_Version'         => '1.0',
                'p1_MerchantNo'      => $this->mchid,
                'p2_OrderNo'         => $orderNo,
                'p3_Amount'          => $paymentAmount * 100,
                'p4_Cur'             => '1',
                'p5_ProductName'     => $paymentTitle,
                'p6_ProductDesc'     => $paymentRemark,
                'p9_NotifyUrl'       => sysuri("@data/api.notify/joinpay/scene/order/param/{$this->code}", [], false, true),
                'q1_FrpCode'         => $tradeType ?? '',
                'q5_OpenId'          => $openid,
                'q7_AppId'           => $this->appid,
                'qa_TradeMerchantNo' => $this->trade,
            ];
            if (empty($data['q5_OpenId'])) unset($data['q5_OpenId']);
            $this->uri = 'https://www.joinpay.com/trade/uniPayApi.action';
            $result = $this->_doReuest($data);
            if (is_array($result) && isset($result['ra_Code']) && intval($result['ra_Code']) === 100) {
                // 创建支付记录
                $this->createPaymentAction($orderNo, $paymentTitle, $paymentAmount);
                // 返回支付参数
                return json_decode($result['rc_Result'], true);
            } elseif (is_array($result) && isset($result['rb_CodeMsg'])) {
                throw new \think\Exception($result['rb_CodeMsg']);
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
     * 查询订单数据
     * @param string $orderNo
     * @return array
     */
    public function query(string $orderNo): array
    {
        $this->uri = 'https://www.joinpay.com/trade/queryOrder.action';
        return $this->_doReuest(['p1_MerchantNo' => $this->mchid, 'p2_OrderNo' => $orderNo]);
    }

    /**
     * 支付结果处理
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function notify(): string
    {
        $notify = $this->app->request->get();
        foreach ($notify as &$item) $item = urldecode($item);
        if (empty($notify['hmac']) || $notify['hmac'] !== $this->_doSign($notify)) {
            return 'error';
        }
        if (isset($notify['r6_Status']) && intval($notify['r6_Status']) === 100) {
            if ($this->updatePaymentAction($notify['r2_OrderNo'], $notify['r9_BankTrxNo'], $notify['r3_Amount'])) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'success';
        }
    }

    /**
     * 请求数据签名
     * @param array $data
     * @return string
     */
    private function _doSign(array $data): string
    {
        ksort($data);
        unset($data['hmac']);
        return md5(join('', $data) . $this->mchkey);
    }

    /**
     * 执行数据请求
     * @param array $data
     * @return array
     */
    private function _doReuest($data = []): array
    {
        $data['hmac'] = $this->_doSign($data);
        return json_decode(HttpExtend::post($this->uri, $data), true);
    }
}