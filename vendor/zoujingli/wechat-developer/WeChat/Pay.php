<?php

// +----------------------------------------------------------------------
// | WeChatDeveloper
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

namespace WeChat;

use WeChat\Contracts\BasicWePay;
use WeChat\Exceptions\InvalidResponseException;
use WePay\Bill;
use WePay\Order;
use WePay\Refund;
use WePay\Transfers;
use WePay\TransfersBank;

/**
 * 微信支付商户
 * Class Pay
 * @package WeChat\Contracts
 */
class Pay extends BasicWePay
{

    /**
     * 统一下单
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function createOrder(array $options)
    {
        $pay = new Order($this->config->get());
        return $pay->create($options);
    }


    /**
     * 创建JsApi及H5支付参数
     * @param string $prepay_id 统一下单预支付码
     * @return array
     */
    public function createParamsForJsApi($prepay_id)
    {
        $pay = new Order($this->config->get());
        return $pay->jsapiParams($prepay_id);
    }

    /**
     * 获取APP支付参数
     * @param string $prepay_id 统一下单预支付码
     * @return array
     */
    public function createParamsForApp($prepay_id)
    {
        $pay = new Order($this->config->get());
        return $pay->appParams($prepay_id);
    }

    /**
     * 获取支付规则二维码
     * @param string $product_id 商户定义的商品id 或者订单号
     * @return string
     */
    public function createParamsForRuleQrc($product_id)
    {
        $pay = new Order($this->config->get());
        return $pay->qrcParams($product_id);
    }

    /**
     * 查询订单
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function queryOrder(array $options)
    {
        $pay = new Order($this->config->get());
        return $pay->query($options);
    }

    /**
     * 关闭订单
     * @param string $out_trade_no 商户订单号
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function closeOrder($out_trade_no)
    {
        $pay = new Order($this->config->get());
        return $pay->close($out_trade_no);
    }

    /**
     * 申请退款
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function createRefund(array $options)
    {
        $pay = new Refund($this->config->get());
        return $pay->create($options);
    }

    /**
     * 查询退款
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function queryRefund(array $options)
    {
        $pay = new Refund($this->config->get());
        return $pay->query($options);
    }

    /**
     * 交易保障
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function report(array $options)
    {
        $pay = new Order($this->config->get());
        return $pay->report($options);
    }

    /**
     * 授权码查询openid
     * @param string $authCode 扫码支付授权码，设备读取用户微信中的条码或者二维码信息
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function queryAuthCode($authCode)
    {
        $pay = new Order($this->config->get());
        return $pay->queryAuthCode($authCode);
    }

    /**
     * 下载对账单
     * @param array $options 静音参数
     * @param null|string $outType 输出类型
     * @return bool|string
     * @throws InvalidResponseException
     */
    public function billDownload(array $options, $outType = null)
    {
        $pay = new Bill($this->config->get());
        return $pay->download($options, $outType);
    }


    /**
     * 拉取订单评价数据
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function billCommtent(array $options)
    {
        $pay = new Bill($this->config->get());
        return $pay->comment($options);
    }

    /**
     * 企业付款到零钱
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function createTransfers(array $options)
    {
        $pay = new Transfers($this->config->get());
        return $pay->create($options);
    }

    /**
     * 查询企业付款到零钱
     * @param string $partner_trade_no 商户调用企业付款API时使用的商户订单号
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function queryTransfers($partner_trade_no)
    {
        $pay = new Transfers($this->config->get());
        return $pay->query($partner_trade_no);
    }

    /**
     * 企业付款到银行卡
     * @param array $options
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws Exceptions\InvalidDecryptException
     * @throws Exceptions\InvalidResponseException
     */
    public function createTransfersBank(array $options)
    {
        $pay = new TransfersBank($this->config->get());
        return $pay->create($options);
    }

    /**
     * 商户企业付款到银行卡操作进行结果查询
     * @param string $partner_trade_no 商户订单号，需保持唯一
     * @return array
     * @throws Exceptions\LocalCacheException
     * @throws InvalidResponseException
     */
    public function queryTransFresBank($partner_trade_no)
    {
        $pay = new TransfersBank($this->config->get());
        return $pay->query($partner_trade_no);
    }
}