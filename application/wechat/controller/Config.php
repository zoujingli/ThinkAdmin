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

namespace app\wechat\controller;

use controller\BasicAdmin;
use service\DataService;
use service\LogService;
use service\PayService;
use think\response\View;

/**
 * 微信配置管理
 * Class Config
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Config extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'SystemConfig';

    /**
     * 微信基础参数配置
     * @return View
     */
    public function index() {
        if ($this->request->isGet()) {
            $this->assign('title', '微信接口配置');
            return view();
        }
        foreach ($this->request->post() as $key => $vo) {
            sysconf($key, $vo);
        }
        LogService::write('微信管理', '修改微信接口参数成功');
        $this->success('数据修改成功！', '');
    }

    /**
     * 微信商户参数配置
     * @return View
     */
    public function pay() {
        if ($this->request->isGet()) {
            switch ($this->request->get('action')) {
                // 生成测试支付二维码
                case 'payqrc':
                    $pay = &load_wechat('pay');
                    // 生成订单号
                    $order_no = session('pay-test-order-no');
                    if (empty($order_no)) {
                        $order_no = DataService::createSequence(10, 'wechat-pay-test');
                        session('pay-test-order-no', $order_no);
                    }
                    // 该订单号已经支付
                    if (PayService::isPay($order_no)) {
                        return json(['code' => 2, 'order_no' => $order_no]);
                    }
                    // 订单号未支付，生成支付二维码URL
                    $url = PayService::createWechatPayQrc($pay, $order_no, 1, '微信扫码支付测试！');
                    if ($url !== false) {
                        return json(['code' => 1, 'url' => $url, 'order_no' => $order_no]);
                    }
                    // 生成支付二维码URL失败
                    $this->error("生成支付二维码失败，{$pay->errMsg}[{$pay->errCode}]");
                    break;
                // 微信支付退款操作
                case 'refund':
                    $order_no = session('pay-test-order-no');
                    if (empty($order_no)) {
                        $this->error('测试订单号不存在，请重新开始支付测试！');
                    }
                    if (!PayService::isPay($order_no)) {
                        $this->error('测试订单未支付或未收到微信支付通过！');
                    }
                    $pay = &load_wechat('pay');
                    if (!file_exists($pay->ssl_cer) || !file_exists($pay->ssl_key)) {
                        $this->error('微信支付双向证书异常，无法完成退款操作！');
                    }
                    $refund_no = DataService::createSequence(10, 'wechat-pay-test');
                    if (false !== PayService::putWechatRefund($pay, $order_no, 1, $refund_no)) {
                        session('pay-test-order-no', null);
                        $this->success('测试退款操作成功，请查看微信通知！', '');
                    }
                    $this->error("操作退款失败，{$pay->errMsg}[{$pay->errCode}]");
                    break;
                // 显示支付配置界面
                default:
                    $this->assign('title', '微信支付配置');
                    return view();
            }
        }
        $data = $this->request->post();
        foreach ($data as $key => $vo) {
            if (in_array($key, ['wechat_cert_key_md5', 'wechat_cert_cert_md5']) && !empty($vo)) {
                $filename = ROOT_PATH . 'static/upload/' . join('/', str_split($vo, 16)) . '.pem';
                !file_exists($filename) && $this->error('支付双向证书上传失败，请重新上传！');
                $data[str_replace('_md5', '', $key)] = $filename;
            }
        }
        unset($data['wechat_cert_key_md5'], $data['wechat_cert_cert_md5']);
        foreach ($data as $key => $vo) {
            DataService::save($this->table, ['name' => $key, 'value' => $vo], 'name');
        }
        LogService::write('微信管理', '修改微信支付参数成功');
        $this->success('数据修改成功！', '');
    }

}
