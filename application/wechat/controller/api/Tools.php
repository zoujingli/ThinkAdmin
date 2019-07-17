<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\service\WechatService;
use library\Controller;

/**
 * 微信测试工具
 * Class Tools
 * @package app\wechat\controller\api
 */
class Tools extends Controller
{
    /**
     * 网页授权测试
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function oauth()
    {
        $this->url = $this->request->url(true);
        $this->fans = WechatService::getWebOauthInfo($this->url, 1);
        $this->fetch();
    }

    /**
     * 显示网页授权二维码
     * @return \think\Response
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     */
    public function oauth_qrc()
    {
        $url = url('@wechat/api.tools/oauth', '', true, true);
        return $this->showQrc($url);
    }

    /**
     * JSSDK测试
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function jssdk()
    {
        $this->options = WechatService::getWebJssdkSign();
        $this->fetch();
    }

    /**
     * 显示网页授权二维码
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     */
    public function jssdk_qrc()
    {
        $this->url = url('@wechat/api.tools/jssdk', '', true, true);
        return $this->showQrc($this->url);
    }

    /**
     * 微信扫码支付模式一二维码显示
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     */
    public function scanOneQrc()
    {
        $pay = WechatService::WePayOrder();
        $result = $pay->qrcParams('8888888');
        $this->showQrc($result);
    }

    /**
     * 微信扫码支付模式一通知处理
     * -- 注意，需要在微信商户配置支付通知地址
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function scanOneNotify()
    {
        $pay = WechatService::WePayOrder();
        $notify = $pay->getNotify();
        p('======= 来自扫码支付1的数据 ======');
        p($notify);
        // 产品ID 你的业务代码，并实现下面的统一下单操作
        $product_id = $notify['product_id'];
        // 微信统一下单处理
        $options = [
            'body'             => '测试商品，产品ID：' . $product_id,
            'out_trade_no'     => time(),
            'total_fee'        => '1',
            'trade_type'       => 'NATIVE',
            'notify_url'       => url('@wechat/api.tools/notify', '', true, true),
            'spbill_create_ip' => request()->ip(),
        ];
        $order = $pay->create($options);
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
        $result['sign'] = $pay->getPaySign($result);
        p('======= 来自扫码支付1返回的结果 ======');
        p($result);
        return \WeChat\Contracts\Tools::arr2xml($result);
    }

    /**
     * 扫码支付模式二测试二维码
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function scanQrc()
    {
        $pay = WechatService::WePayOrder();
        $result = $pay->create([
            'body'             => '测试商品',
            'out_trade_no'     => time(),
            'total_fee'        => '1',
            'trade_type'       => 'NATIVE',
            'notify_url'       => url('@wechat/api.tools/notify', '', true, true),
            'spbill_create_ip' => request()->ip(),
        ]);
        $this->showQrc($result['code_url']);
    }


    /**
     * 微信JSAPI支付二维码
     * @return \think\Response
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     */
    public function jsapiQrc()
    {
        $this->url = url('@wechat/api.tools/jsapi', '', true, true);
        return $this->showQrc($this->url);
    }

    /**
     * 微信JSAPI支付测试
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @link wx-demo-jsapi
     */
    public function jsapi()
    {
        $pay = WechatService::WePayOrder();
        $openid = WechatService::getWebOauthInfo(request()->url(true), 0)['openid'];
        $options = [
            'body'             => '测试商品',
            'out_trade_no'     => time(),
            'total_fee'        => '1',
            'openid'           => $openid,
            'trade_type'       => 'JSAPI',
            'notify_url'       => url('@wechat/api.tools/notify', '', true, true),
            'spbill_create_ip' => request()->ip(),
        ];
        // 生成预支付码
        $result = $pay->create($options);
        // 创建JSAPI参数签名
        $options = $pay->jsapiParams($result['prepay_id']);
        $optionJSON = json_encode($options, JSON_UNESCAPED_UNICODE);
        // JSSDK 签名配置
        $configJSON = json_encode(WechatService::getWebJssdkSign(), JSON_UNESCAPED_UNICODE);

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
        $wechat = WechatService::WePayOrder();
        p($wechat->getNotify());
        return 'SUCCESS';
    }

    /**
     * 创建二维码响应对应
     * @param string $url 二维码内容
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionFailedException
     * @throws \Endroid\QrCode\Exceptions\ImageFunctionUnknownException
     * @throws \Endroid\QrCode\Exceptions\ImageTypeInvalidException
     */
    protected function showQrc($url)
    {
        $qrCode = new \Endroid\QrCode\QrCode();
        $qrCode->setText($url)->setSize(300)->setPadding(20)->setImageType('png');
        response($qrCode->get(), 200, ['Content-Type' => 'image/png'])->send();
    }

}
