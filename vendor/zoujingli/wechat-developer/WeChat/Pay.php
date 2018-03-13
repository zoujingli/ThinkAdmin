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

use WeChat\Contracts\DataArray;
use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidArgumentException;
use WeChat\Exceptions\InvalidResponseException;

/**
 * 微信支付商户
 * Class Pay
 * @package WeChat\Contracts
 */
class Pay
{

    /**
     * 商户配置
     * @var DataArray
     */
    protected $config;

    /**
     * 当前请求数据
     * @var DataArray
     */
    protected $params;


    /**
     * WeChat constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (empty($options['appid'])) {
            throw new InvalidArgumentException("Missing Config -- [appid]");
        }
        if (empty($options['mch_id'])) {
            throw new InvalidArgumentException("Missing Config -- [mch_id]");
        }
        if (empty($options['mch_key'])) {
            throw new InvalidArgumentException("Missing Config -- [mch_key]");
        }
        if (!empty($options['cache_path'])) {
            Tools::$cache_path = $options['cache_path'];
        }
        $this->config = new DataArray($options);
        $this->params = new DataArray([
            'appid'     => $this->config->get('appid'),
            'mch_id'    => $this->config->get('mch_id'),
            'nonce_str' => Tools::createNoncestr(),
        ]);
    }

    /**
     * 统一下单
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     */
    public function createOrder(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        return $this->callPostApi($url, $options);
    }

    /**
     * 查询订单
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     */
    public function queryOrder(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/orderquery';
        return $this->callPostApi($url, $options);
    }

    /**
     * 关闭订单
     * @param string $out_trade_no 商户订单号
     * @return array
     * @throws InvalidResponseException
     */
    public function closeOrder($out_trade_no)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/closeorder';
        return $this->callPostApi($url, ['out_trade_no' => $out_trade_no]);
    }

    /**
     * 申请退款
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     */
    public function createRefund(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        return $this->callPostApi($url, $options, true);
    }

    /**
     * 查询退款
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     */
    public function queryRefund(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/refundquery';
        return $this->callPostApi($url, $options);
    }

    /**
     * 交易保障
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     */
    public function report(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/payitil/report';
        return $this->callPostApi($url, $options);
    }

    /**
     * 授权码查询openid
     * @param string $authCode 扫码支付授权码，设备读取用户微信中的条码或者二维码信息
     * @return array
     * @throws InvalidResponseException
     */
    public function queryAuthCode($authCode)
    {
        $url = 'https://api.mch.weixin.qq.com/tools/authcodetoopenid';
        return $this->callPostApi($url, ['auth_code' => $authCode]);
    }

    /**
     * 转换短链接
     * @param string $longUrl 需要转换的URL，签名用原串，传输需URLencode
     * @return array
     * @throws InvalidResponseException
     */
    public function shortUrl($longUrl)
    {
        $url = 'https://api.mch.weixin.qq.com/tools/shorturl';
        return $this->callPostApi($url, ['long_url' => $longUrl]);
    }

    /**
     * 下载对账单
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     */
    public function billDownload(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/downloadbill';
        return $this->callPostApi($url, $options);
    }


    /**
     * 拉取订单评价数据
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     */
    public function billCommtent(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/billcommentsp/batchquerycomment';
        return $this->callPostApi($url, $options, true);
    }

    /**
     * 企业付款到零钱
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     */
    public function createTransfers(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        return $this->callPostApi($url, $options, true);
    }

    /**
     * 查询企业付款到零钱
     * @param string $partner_trade_no 商户调用企业付款API时使用的商户订单号
     * @return array
     * @throws InvalidResponseException
     */
    public function queryTransfers($partner_trade_no)
    {
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo';
        return $this->callPostApi($url, ['partner_trade_no' => $partner_trade_no], true);
    }

    /**
     * 获取微信支付通知
     * @return array
     * @throws InvalidResponseException
     */
    public function getNotify()
    {
        $data = Tools::xml2arr(file_get_contents('php://input'));
        if (!empty($data['sign'])) {
            if ($this->getPaySign($data) === $data['sign']) {
                return $data;
            }
        }
        throw new InvalidResponseException('Invalid Notify.', '0');
    }

    /**
     * 生成支付签名
     * @param array $data
     * @return string
     */
    public function getPaySign(array $data)
    {
        unset($data['sign']);
        ksort($data);
        list($key, $str) = [$this->config->get('mch_key'), ''];
        foreach ($data as $k => $v) {
            $str .= "{$k}={$v}&";
        }
        return strtoupper(hash_hmac('SHA256', "{$str}key={$key}", $key));
    }

    /**
     * 以Post请求接口
     * @param string $url 请求
     * @param array $data 接口参数
     * @param bool $isCert 是否需要使用双向证书
     * @return array
     * @throws InvalidResponseException
     */
    public function callPostApi($url, array $data, $isCert = false)
    {
        $option = [];
        if ($isCert) {
            foreach (['ssl_cer', 'ssl_key'] as $key) {
                if (empty($options[$key])) {
                    throw new InvalidArgumentException("Missing Config -- [{$key}]", '0');
                }
            }
            $option['ssl_cer'] = $this->config->get('ssl_cer');
            $option['ssl_key'] = $this->config->get('ssl_key');
        }
        $params = $this->params->merge($data);
        $params['sign_type'] = 'HMAC-SHA256';
        $params['sign'] = $this->getPaySign($params);
        $result = Tools::xml2arr(Tools::post($url, Tools::arr2xml($params), $option));
        if ($result['return_code'] !== 'SUCCESS') {
            throw new InvalidResponseException($result['return_msg'], '0');
        }
        return $result;
    }
}