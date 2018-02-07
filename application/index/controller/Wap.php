<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\index\controller;

use controller\BasicWechat;
use service\DataService;
use service\PayService;

class Wap extends BasicWechat
{

    /**
     * 网页授权DEMO
     */
    public function index()
    {
        dump($this->oAuth(true)); // 获取用户详情信息
        dump($this->fansinfo); // 输出用户信息
    }

    /**
     * 微信二维码支付DEMO
     * @return \think\response\Json|\think\response\View
     */
    public function payqrc()
    {
        $method = '_payqrc_' . strtolower($this->request->get('action'));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return view();
    }

    /**
     * 获取二维码支付
     * @return \think\response\Json
     */
    protected function _payqrc_payqrc()
    {
        list($pay, $order_no) = [load_wechat('pay'), session('pay-test-order-no')];
        if (empty($order_no)) {
            $order_no = DataService::createSequence(10, 'wechat-pay-test');
            session('pay-test-order-no', $order_no);
        }
        if (PayService::isPay($order_no)) {
            return json(['code' => 2, 'order_no' => $order_no]);
        }
        $url = PayService::createWechatPayQrc($pay, $order_no, 1, '微信扫码支付测试！');
        if ($url !== false) {
            return json(['code' => 1, 'url' => $url, 'order_no' => $order_no]);
        }
        $this->error("生成支付二维码失败，{$pay->errMsg}[{$pay->errCode}]");
    }

    /**
     * 重置测试订单号
     */
    protected function _payqrc_reset()
    {
        session('pay-test-order-no', null);
    }

    /**
     * 微信JSAPI支付DEMO
     * @return \think\response\Json|\think\response\View
     */
    public function payjs()
    {
        $this->openid = $this->oAuth(false);
        $method = '_payjs_' . strtolower($this->request->get('action'));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return view();
    }

    /**
     * 获取JSAPI支付参数
     * @return \think\response\Json
     */
    protected function _payjs_options()
    {
        $order_no = session('pay-test-order-no');
        if (empty($order_no)) {
            $order_no = DataService::createSequence(10, 'wechat-pay-test');
            session('pay-test-order-no', $order_no);
        }
        if (PayService::isPay($order_no)) {
            return json(['code' => 2, 'order_no' => $order_no]);
        }
        $pay = load_wechat('pay');
        $options = PayService::createWechatPayJsPicker($pay, $this->openid, $order_no, 1, 'JSAPI支付测试');
        if ($options === false) {
            $options = ['code' => 3, 'msg' => "创建支付失败，{$pay->errMsg}[$pay->errCode]"];
        }
        $options['order_no'] = $order_no;
        return json($options);
    }

    /**
     * 重置测试订单号
     */
    protected function _payjs_reset()
    {
        session('pay-test-order-no', null);
    }

}
