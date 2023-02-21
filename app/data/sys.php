<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

use app\data\command\OrderClean;
use app\data\command\UserAgent;
use app\data\command\UserAmount;
use app\data\command\UserTransfer;
use app\data\command\UserUpgrade;
use app\data\service\OrderService;
use app\data\service\RebateService;
use app\data\service\UserBalanceService;
use app\data\service\UserRebateService;
use think\admin\Library;
use think\Console;

if (Library::$sapp->request->isCli()) {
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
    Library::$sapp->event->listen('ShopOrderPayment', function ($orderNo) {

        Library::$sapp->log->notice("订单 {$orderNo} 支付事件，执行用户返利行为");
        RebateService::instance()->execute($orderNo);

        Library::$sapp->log->notice("订单 {$orderNo} 支付事件，执行发放余额行为");
        UserBalanceService::confirm($orderNo);

        Library::$sapp->log->notice("订单 {$orderNo} 支付事件，执行用户升级行为");
        OrderService::upgrade($orderNo);
    });

    // 注册订单确认支付事件
    Library::$sapp->event->listen('ShopOrderConfirm', function ($orderNo) {
        Library::$sapp->log->notice("订单 {$orderNo} 确认事件，执行返利确认行为");
        UserRebateService::confirm($orderNo);
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