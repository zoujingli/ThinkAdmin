<?php
// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\index\controller;

use controller\BasicWechat;
use service\DataService;
use service\PayService;

class Wap extends BasicWechat {

    protected $check_auth = false;

    public function index() {
        $this->oAuth();
        dump($this->fansinfo);
    }

    public function payqrc() {
        switch ($this->request->get('action')) {
            case 'payqrc':
                $pay = &load_wechat('pay');
                $order_no = session('pay-test-order-no');
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
                break;
            case 'reset':
                session('pay-test-order-no', null);
                break;
            default:
                return view();
        }
    }

    public function payjs() {
        $this->openid = $this->oAuth(false);
        $this->assign('jsSign', load_wechat('script')->getJsSign($this->url));
        switch ($this->request->get('action')) {
            case 'options':
                $order_no = session('pay-test-order-no');
                if (empty($order_no)) {
                    $order_no = DataService::createSequence(10, 'wechat-pay-test');
                    session('pay-test-order-no', $order_no);
                }
                if (PayService::isPay($order_no)) {
                    return json(['code' => 2, 'order_no' => $order_no]);
                }
                $pay = &load_wechat('pay');
                $options = PayService::createWechatPayJsPicker($pay, $this->openid, $order_no, 1, 'JSAPI支付测试');
                if ($options === false) {
                    $options = ['code' => 3, 'msg' => "创建支付失败，{$pay->errMsg}[$pay->errCode]"];
                }
                return json($options);
            case 'reset':
                session('pay-test-order-no', null);
                break;
            default:
                return view();

        }
    }
}