<?php

namespace app\data\controller\api;

use app\data\service\payment\AlipayPaymentService;
use app\data\service\payment\JoinPaymentService;
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
     * @param string $param 支付通道
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
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
     * @param string $param 支付通道
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
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
     * @param string $param 支付通道
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function joinpay(string $scene = 'order', string $param = ''): string
    {
        if (strtolower($scene) === 'order') {
            return JoinPaymentService::instance($param)->notify();
        } else {
            return 'success';
        }
    }
}