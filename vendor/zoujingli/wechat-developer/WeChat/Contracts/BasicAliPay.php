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

namespace WeChat\Contracts;

use WeChat\Exceptions\InvalidArgumentException;

/**
 * 支付宝支付基类
 * Class AliPay
 * @package AliPay\Contracts
 */
abstract class BasicAliPay
{

    /**
     * 支持配置
     * @var DataArray
     */
    protected $config;

    /**
     * 当前请求数据
     * @var DataArray
     */
    protected $options;

    /**
     * DzContent数据
     * @var DataArray
     */
    protected $params;

    /**
     * 正常请求网关
     * @var string
     */
    protected $gateway = 'https://openapi.alipay.com/gateway.do?charset=utf-8';

    /**
     * AliPay constructor.
     * @param array $options
     */
    public function __construct($options)
    {
        $this->params = new DataArray([]);
        $this->config = new DataArray($options);
        if (empty($options['appid'])) {
            throw new InvalidArgumentException("Missing Config -- [appid]");
        }
        if (empty($options['public_key'])) {
            throw new InvalidArgumentException("Missing Config -- [public_key]");
        }
        if (empty($options['private_key'])) {
            throw new InvalidArgumentException("Missing Config -- [private_key]");
        }
        if (!empty($options['debug'])) {
            $this->gateway = 'https://openapi.alipaydev.com/gateway.do?charset=utf-8';
        }
        $this->options = new DataArray([
            'app_id'    => $this->config->get('appid'),
            'charset'   => empty($options['charset']) ? 'utf-8' : $options['charset'],
            'format'    => 'JSON',
            'version'   => '1.0',
            'sign_type' => 'RSA2',
            'timestamp' => date('Y-m-d H:i:s'),
        ]);
        if (isset($options['notify_url']) && $options['notify_url'] !== '') {
            $this->options->set('notify_url', $options['notify_url']);
        }
        if (isset($options['return_url']) && $options['return_url'] !== '') {
            $this->options->set('return_url', $options['return_url']);
        }
        if (isset($options['app_auth_token']) && $options['app_auth_token'] !== '') {
            $this->options->set('app_auth_token', $options['app_auth_token']);
        }
    }

    /**
     * 查询支付宝订单状态
     * @param string $out_trade_no
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function query($out_trade_no = '')
    {
        $this->options['method'] = 'alipay.trade.query';
        return $this->getResult(['out_trade_no' => $out_trade_no]);
    }

    /**
     * 支付宝订单退款操作
     * @param array|string $options 退款参数或退款商户订单号
     * @param null $refund_amount 退款金额
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function refund($options, $refund_amount = null)
    {
        if (!is_array($options)) $options = ['out_trade_no' => $options, 'refund_amount' => $refund_amount];
        $this->options['method'] = 'alipay.trade.refund';
        return $this->getResult($options);
    }

    /**
     * 关闭支付宝进行中的订单
     * @param array|string $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function close($options)
    {
        if (!is_array($options)) $options = ['out_trade_no' => $options];
        $this->options['method'] = 'alipay.trade.close';
        return $this->getResult($options);
    }

    /**
     * 验证支付宝支付宝通知
     * @param array $data 通知数据
     * @param null $sign 数据签名
     * @param boolean $sync
     * @return array|bool
     */
    public function verify($data, $sign = null, $sync = false)
    {
        if (is_null($this->config->get('public_key'))) {
            throw new InvalidArgumentException('Missing Config -- [public_key]');
        }
        $sign = is_null($sign) ? $data['sign'] : $sign;
        $content = wordwrap($this->config->get('public_key'), 64, "\n", true);
        $string = $sync ? json_encode($data) : $this->getSignContent($data, true);
        $res = "-----BEGIN PUBLIC KEY-----\n{$content}\n-----END PUBLIC KEY-----";
        return openssl_verify($string, base64_decode($sign), $res, OPENSSL_ALGO_SHA256) === 1 ? $data : false;
    }

    /**
     * 获取数据签名
     * @return string
     */
    protected function getSign()
    {
        if (is_null($this->config->get('private_key'))) {
            throw new InvalidArgumentException('Missing Config -- [private_key]');
        }
        $content = wordwrap($this->config->get('private_key'), 64, "\n", true);
        $string = "-----BEGIN RSA PRIVATE KEY-----\n{$content}\n-----END RSA PRIVATE KEY-----";
        openssl_sign($this->getSignContent($this->options->get()), $sign, $string, OPENSSL_ALGO_SHA256);
        return base64_encode($sign);
    }

    /**
     * 数据签名处理
     * @param array $data
     * @param boolean $verify
     * @param array $strs
     * @return bool|string
     */
    private function getSignContent(array $data, $verify = false, $strs = [])
    {
        ksort($data);
        foreach ($data as $k => $v) if ($v !== '') {
            if ($verify && $k != 'sign' && $k != 'sign_type') array_push($strs, "{$k}={$v}");
            if (!$verify && $v !== '' && !is_null($v) && $k != 'sign' && '@' != substr($v, 0, 1)) array_push($strs, "{$k}={$v}");
        }
        return join('&', $strs);
    }

    /**
     * 数据包生成及数据签名
     * @param array $options
     */
    protected function applyData($options)
    {
        $this->options['biz_content'] = json_encode($options, JSON_UNESCAPED_UNICODE);
        $this->options['sign'] = $this->getSign();
    }

    /**
     * 请求接口并验证访问数据
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    protected function getResult($options)
    {
        $this->applyData($options);
        $method = str_replace('.', '_', $this->options['method']) . '_response';
        $data = json_decode(Tools::get($this->gateway, $this->options->get()), true);
        if (!isset($data[$method]['code']) || $data[$method]['code'] !== '10000') {
            throw new \WeChat\Exceptions\InvalidResponseException(
                "Error: " .
                (empty($data[$method]['code']) ? '' : "{$data[$method]['msg']} [{$data[$method]['code']}]\r\n") .
                (empty($data[$method]['sub_code']) ? '' : "{$data[$method]['sub_msg']} [{$data[$method]['sub_code']}]\r\n"),
                $data[$method]['code'], $data
            );
        }
        return $this->verify($data[$method], $data['sign'], true);
    }

    /**
     * 生成支付html代码
     * @return string
     */
    protected function buildPayHtml()
    {
        $html = "<form id='alipaysubmit' name='alipaysubmit' action='{$this->gateway}' method='post'>";
        foreach ($this->params->get() as $key => $value) {
            $value = str_replace("'", '&apos;', $value);
            $html .= "<input type='hidden' name='{$key}' value='{$value}'/>";
        }
        $html .= "<input type='submit' value='ok' style='display:none;'></form>";
        return "{$html}<script>document.forms['alipaysubmit'].submit();</script>";
    }

    /**
     * 应用数据操作
     * @param array $options
     * @return mixed
     */
    abstract public function apply($options);

}