<?php

use app\data\command\OrderClear;
use app\data\command\UserBalance;
use app\data\command\UserUpgrade;
use app\data\command\UserTransfer;
use app\data\service\OrderService;
use app\data\service\RebateCurrentService;
use think\Console;

if (app()->request->isCli()) {
    Console::starting(function (Console $console) {
        $console->addCommand(OrderClear::class);
        $console->addCommand(UserBalance::class);
        $console->addCommand(UserUpgrade::class);
        $console->addCommand(UserTransfer::class);
    });
} else {
    // 注册订单支付处理事件
    app()->event->listen('ShopOrderPayment', function ($orderNo) {
        app()->log->notice("订单支付事件，订单号：{$orderNo}");
        OrderService::instance()->syncUserLevel($orderNo);
        RebateCurrentService::instance()->execute($orderNo);
    });
}

if (!function_exists('show_goods_spec')) {
    /**
     * 商品规格过滤显示
     * @param string $spec 原规格内容
     * @return string
     */
    function show_goods_spec(string $spec): string
    {
        $specs = [];
        foreach (explode(';;', $spec) as $sp) {
            $specs[] = explode('::', $sp)[1];
        }
        return join(' ', $specs);
    }
}