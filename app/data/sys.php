<?php

use app\data\command\OrderClear;
use app\data\command\UserAmount;
use app\data\command\UserTransfer;
use app\data\command\UserUpgrade;
use app\data\service\OrderService;
use app\data\service\RebateService;
use app\data\service\UserBalanceService;
use app\data\service\UserRebateService;
use think\Console;

if (app()->request->isCli()) {
    Console::starting(function (Console $console) {
        $console->addCommand(OrderClear::class);
        $console->addCommand(UserAmount::class);
        $console->addCommand(UserUpgrade::class);
        $console->addCommand(UserTransfer::class);
    });
} else {
    // 注册订单支付处理事件
    app()->event->listen('ShopOrderPayment', function ($orderNo) {
        app()->log->notice("订单 {$orderNo} 支付事件，执行用户升级行为");
        OrderService::instance()->upgrade($orderNo);

        app()->log->notice("订单 {$orderNo} 支付事件，执行用户返利行为");
        RebateService::instance()->execute($orderNo);

        app()->log->notice("订单 {$orderNo} 支付事件，执行发放余额行为");
        UserBalanceService::instance()->confirm($orderNo);
    });
    // 注册订单确认支付事件
    app()->event->listen('ShopOrderConfirm', function ($orderNo) {
        app()->log->notice("订单 {$orderNo} 确认事件，执行返利确认行为");
        UserRebateService::instance()->confirm($orderNo);
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