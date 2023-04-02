<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\service\MediaService;
use app\wechat\service\WechatService;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\Response;
use WeChat\Contracts\Tools;

/**
 * 微信测试工具
 * @class Test
 * @package app\wechat\controller\api
 */
class Test extends Controller
{
    /**
     * 微信JSAPI支付二维码
     * @return \think\Response
     */
    public function jsapiQrc(): Response
    {
        $this->url = sysuri('wechat/api.test/jsapi', [], false, true);
        return $this->_buildQrcResponse($this->url);
    }

    /**
     * 显示网页授权二维码
     * @return \think\Response
     */
    public function oauthQrc(): Response
    {
        $this->url = sysuri('wechat/api.test/oauth', [], false, true);
        return $this->_buildQrcResponse($this->url);
    }

    /**
     * 显示网页授权二维码
     * @return \think\Response
     */
    public function jssdkQrc(): Response
    {
        $this->url = sysuri('wechat/api.test/jssdk', [], false, true);
        return $this->_buildQrcResponse($this->url);
    }

    /**
     * 微信扫码支付模式一二维码显示
     * @return \think\Response
     */
    public function scanOneQrc(): Response
    {
        $pay = WechatService::WePayOrder();
        return $this->_buildQrcResponse($pay->qrcParams('8888888'));
    }

    /**
     * 扫码支付模式二测试二维码
     * @return \think\Response
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function scanTwoQrc(): Response
    {
        $result = WechatService::WePayOrder()->create([
            'body'             => '测试商品',
            'total_fee'        => '1',
            'trade_type'       => 'NATIVE',
            'notify_url'       => sysuri('wechat/api.test/notify', [], false, true),
            'out_trade_no'     => CodeExtend::uniqidNumber(18),
            'spbill_create_ip' => $this->request->ip(),
        ]);
        return $this->_buildQrcResponse($result['code_url']);
    }

    /**
     * 网页授权测试
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public function oauth()
    {
        $this->url = $this->request->url(true);
        $this->fans = WechatService::getWebOauthInfo($this->url, 1);
        $this->fetch();
    }

    /**
     * JSSDK测试
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public function jssdk()
    {
        $this->options = WechatService::getWebJssdkSign();
        $this->fetch();
    }

    /**
     * 微信扫码支付模式一通知处理
     * -- 注意，需要在微信商户配置支付通知地址
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function scanOneNotify(): string
    {
        $pay = WechatService::WePayOrder();
        $notify = $pay->getNotify();
        p('======= 来自扫码支付1的数据 ======');
        p($notify);
        // 微信统一下单处理
        $options = [
            'body'             => "测试商品，商品ID：{$notify['product_id']}",
            'total_fee'        => '1',
            'trade_type'       => 'NATIVE',
            'notify_url'       => sysuri('wechat/api.test/notify', [], false, true),
            'out_trade_no'     => CodeExtend::uniqidDate(18),
            'spbill_create_ip' => $this->request->ip(),
        ];
        p('======= 来自扫码支付1统一下单结果 ======');
        p($order = $pay->create($options));
        // 回复XML文本
        $result = [
            'return_code' => 'SUCCESS',
            'return_msg'  => '处理成功',
            'appid'       => $notify['appid'],
            'mch_id'      => $notify['mch_id'],
            'nonce_str'   => Tools::createNoncestr(),
            'prepay_id'   => $order['prepay_id'],
            'result_code' => 'SUCCESS',
        ];
        $result['sign'] = $pay->getPaySign($result);
        p('======= 来自扫码支付1返回的结果 ======');
        p($result);
        return Tools::arr2xml($result);
    }

    /**
     * 微信JSAPI支付测试
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     */
    public function jsapi(): string
    {
        $this->url = $this->request->url(true);
        $this->pay = WechatService::WePayOrder();
        $user = WechatService::getWebOauthInfo($this->url);
        if (empty($user['openid'])) return '<h3>网页授权获取OPENID失败！</h3>';
        // 生成预支付码
        $result = $this->pay->create([
            'body'             => '测试商品',
            'openid'           => $user['openid'],
            'total_fee'        => '1',
            'trade_type'       => 'JSAPI',
            'notify_url'       => sysuri('wechat/api.test/notify', [], false, true),
            'out_trade_no'     => CodeExtend::uniqidDate(18),
            'spbill_create_ip' => $this->request->ip(),
        ]);
        // 数据参数格式化
        $resultJson = var_export($result, true);
        $optionJson = json_encode($this->pay->jsapiParams($result['prepay_id']), JSON_UNESCAPED_UNICODE);
        $configJson = json_encode(WechatService::getWebJssdkSign(), JSON_UNESCAPED_UNICODE);
        return <<<HTML
<pre>
    当前用户OPENID: {$user['openid']}
    \n\n--- 创建微信预支付码结果 ---\n {$resultJson}
    \n\n--- JSAPI 及 H5 支付参数 ---\n {$optionJson}
</pre>
<button id='paytest' type='button'>JSAPI支付测试</button>
<script src='//res.wx.qq.com/open/js/jweixin-1.6.0.js'></script>
<script>
    wx.config({$configJson});
    document.getElementById('paytest').onclick = function(){
        var options = {$optionJson};
        options.success = function(){
            alert('支付成功');
        }
        wx.chooseWXPay(options);
    }
</script>
HTML;
    }

    /**
     * 支付通知接收处理
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function notify(): string
    {
        $wechat = WechatService::WePayOrder();
        p($wechat->getNotify());
        return 'SUCCESS';
    }

    /**
     * 创建二维码响应对应
     * @param string $url 二维码内容
     * @return \think\Response
     */
    private function _buildQrcResponse(string $url): Response
    {
        $result = MediaService::getQrcode($url);
        return response($result->getString(), 200, ['Content-Type' => $result->getMimeType()]);
    }
}
