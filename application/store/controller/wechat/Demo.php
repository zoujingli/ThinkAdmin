<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\store\controller\wechat;

use Endroid\QrCode\QrCode;
use service\WechatService;
use WeChat\Pay;

/**
 * 微信功能demo
 * Class Demo
 * @package app\store\controller\wechat
 */
class Demo
{

    /**
     * 微信扫码支付模式一二维码显示
     * @return \think\Response
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     */
    public function scanOneQrc()
    {
        $wechat = new Pay(config('wechat.'));
        $result = $wechat->createParamsForRuleQrc('8888888');
        return $this->createQrc($result);
    }

    /**
     * 微信扫码支付模式一通知处理
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function scanOneNotify()
    {
        $wechat = new Pay(config('wechat.'));
        $notify = $wechat->getNotify();
        p('======= 来自扫码支付1的数据 ======');
        p($notify);
        // 产品ID @todo 你的业务，并实现下面的统一下单操作
        $product_id = $notify['product_id'];
        // 微信统一下单处理
        $options = [
            'body'             => '测试商品，产品ID：' . $product_id,
            'out_trade_no'     => time(),
            'total_fee'        => '1',
            'trade_type'       => 'NATIVE',
            'notify_url'       => url('@wx-demo-notify', '', true, true),
            'spbill_create_ip' => request()->ip(),
        ];
        $order = $wechat->createOrder($options);
        p('======= 来自扫码支付1统一下单结果 ======');
        p($order);
        // 回复XML文本
        $result = [
            'return_code' => 'SUCCESS',
            'return_msg'  => '处理成功',
            'appid'       => $notify['appid'],
            'mch_id'      => $notify['mch_id'],
            'nonce_str'   => \WeChat\Contracts\Tools::createNoncestr(),
            'prepay_id'   => $order['prepay_id'],
            'result_code' => 'SUCCESS',
        ];
        $result['sign'] = $wechat->getPaySign($result);
        p('======= 来自扫码支付1返回的结果 ======');
        p($result);
        return \WeChat\Contracts\Tools::arr2xml($result);
    }

    /**
     * 扫码支付模式二测试二维码
     * @return \think\Response
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function scanQrc()
    {

        $wechat = new Pay(config('wechat.'));
        $options = [
            'body'             => '测试商品',
            'out_trade_no'     => time(),
            'total_fee'        => '1',
            'trade_type'       => 'NATIVE',
            'notify_url'       => url('@wx-demo-notify', '', true, true),
            'spbill_create_ip' => request()->ip(),
        ];
        // 生成预支付码
        $result = $wechat->createOrder($options);
        return $this->createQrc($result['code_url']);
    }


    /**
     * 公众号JSAPI支付二维码
     * @return \think\Response
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     */
    public function jsapiQrc()
    {
        $url = url('@wx-demo-jsapi', '', true, true);
        return $this->createQrc($url);
    }

    /**
     * 公众号JSAPI支付测试
     * @link wx-demo-jsapi
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function jsapi()
    {
        $wechat = new Pay(config('wechat.'));
        $openid = WechatService::webOauth(request()->url(true), 0)['openid'];
        $options = [
            'body'             => '测试商品',
            'out_trade_no'     => time(),
            'total_fee'        => '1',
            'openid'           => $openid,
            'trade_type'       => 'JSAPI',
            'notify_url'       => url('@wx-demo-notify', '', true, true),
            'spbill_create_ip' => request()->ip(),
        ];
        // 生成预支付码
        $result = $wechat->createOrder($options);
        // 创建JSAPI参数签名
        $options = $wechat->createParamsForJsApi($result['prepay_id']);
        $optionJSON = json_encode($options, JSON_UNESCAPED_UNICODE);
        // JSSDK 签名配置
        $configJSON = json_encode(WechatService::webJsSDK(), JSON_UNESCAPED_UNICODE);

        echo '<pre>';
        echo "当前用户OPENID: {$openid}";
        echo "\n--- 创建预支付码 ---\n";
        var_export($result);
        echo '</pre>';

        echo '<pre>';
        echo "\n\n--- JSAPI 及 H5 参数 ---\n";
        var_export($options);
        echo '</pre>';
        echo "<button id='paytest' type='button'>JSAPI支付测试</button>";
        echo "
        <script src='//res.wx.qq.com/open/js/jweixin-1.2.0.js'></script>
        <script>
            wx.config($configJSON);
            document.getElementById('paytest').onclick = function(){
                var options = $optionJSON;
                options.success = function(){
                    alert('支付成功');
                }
                wx.chooseWXPay(options);
            }
        </script>";
    }

    /**
     * 支付通知接收处理
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function notify()
    {
        $wechat = new Pay(config('wechat.'));
        p($wechat->getNotify());
        return 'SUCCESS';
    }

    /**
     * 显示二维码
     * @param string $url
     * @return \think\Response
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     */
    protected function createQrc($url)
    {
        $qrCode = new QrCode();
        $qrCode->setText($url)->setSize(300)->setPadding(20)->setImageType(QrCode::IMAGE_TYPE_PNG);
        return \think\facade\Response::header('Content-Type', 'image/png')->data($qrCode->get());
    }

}