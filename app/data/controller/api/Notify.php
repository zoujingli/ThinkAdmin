<?php

namespace app\data\controller\api;

use app\data\service\payment\AlipayPaymentService;
use app\data\service\payment\JoinpayPaymentService;
use app\data\service\payment\WechatPaymentService;
use think\admin\Controller;

/**
 * 异步通知处理
 * Class Notify
 * @package app\data\controller\api
 */
class Notify extends Controller
{
    /**
     * 微信支付通知
     * @param string $scene 支付场景
     * @param string $param 支付参数
     * @return string
     * @throws \think\admin\Exception
     */
    public function wxpay(string $scene = 'order', string $param = ''): string
    {
        if (strtolower($scene) === 'order') {
            return WechatPaymentService::instance($param)->notify();
        } else {
            return 'success';
        }
    }

    /**
     * 支付宝支付通知
     * @param string $scene 支付场景
     * @param string $param 支付参数
     * @return string
     * @throws \think\admin\Exception
     */
    public function alipay(string $scene = 'order', string $param = ''): string
    {
        if (strtolower($scene) === 'order') {
            return AlipayPaymentService::instance($param)->notify();
        } else {
            return 'success';
        }
    }

    /**
     * 汇聚支付通知
     * @param string $scene 支付场景
     * @param string $param 支付参数
     * @return string
     * @throws \think\admin\Exception
     */
    public function joinpay(string $scene = 'order', string $param = ''): string
    {
        if (strtolower($scene) === 'order') {
            return JoinpayPaymentService::instance($param)->notify();
        } else {
            return 'success';
        }
    }
}