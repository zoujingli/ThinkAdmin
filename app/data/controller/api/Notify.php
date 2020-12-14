<?php

namespace app\data\controller\api;

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
     * @return string
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function wxpay(string $scene = 'order'): string
    {
        if (strtolower($scene) === 'order') {
            return WechatPaymentService::instance()->notify();
        } else {
            return 'success';
        }
    }

    /**
     * 汇聚支付通知
     * @param string $scene 支付场景
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function joinpay(string $scene = 'order'): string
    {
        if (strtolower($scene) === 'order') {
            return JoinPaymentService::instance()->notify();
        } else {
            return 'success';
        }
    }
}