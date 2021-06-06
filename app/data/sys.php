<?php

use app\data\command\OrderClean;
use app\data\command\UserAgent;
use app\data\command\UserAmount;
use app\data\command\UserTransfer;
use app\data\command\UserUpgrade;
use app\data\service\OrderService;
use app\data\service\RebateService;
use app\data\service\UserBalanceService;
use app\data\service\UserRebateService;
use think\Console;

$app = app();

if ($app->request->isCli()) {
    // 动态注册操作指令
    Console::starting(function (Console $console) {
        $console->addCommand(OrderClean::class);
        $console->addCommand(UserAgent::class);
        $console->addCommand(UserAmount::class);
        $console->addCommand(UserUpgrade::class);
        $console->addCommand(UserTransfer::class);
    });
} else {
    // 注册订单支付处理事件
    $app->event->listen('ShopOrderPayment', function ($orderNo) use ($app) {
        $app->log->notice("订单 {$orderNo} 支付事件，执行用户升级行为");
        OrderService::instance()->upgrade($orderNo);

        $app->log->notice("订单 {$orderNo} 支付事件，执行用户返利行为");
        RebateService::instance()->execute($orderNo);

        $app->log->notice("订单 {$orderNo} 支付事件，执行发放余额行为");
        UserBalanceService::instance()->confirm($orderNo);
    });

    // 注册订单确认支付事件
    $app->event->listen('ShopOrderConfirm', function ($orderNo) use ($app) {
        $app->log->notice("订单 {$orderNo} 确认事件，执行返利确认行为");
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