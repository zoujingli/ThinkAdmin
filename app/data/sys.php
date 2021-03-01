<?php

use app\data\command\OrderClear;
use app\data\command\UserBalance;
use app\data\command\UserLevel;
use app\data\command\UserTransfer;
use think\Console;

if (app()->request->isCli()) {
    Console::starting(function (Console $console) {
        $console->addCommand(OrderClear::class);
        $console->addCommand(UserBalance::class);
        $console->addCommand(UserLevel::class);
        $console->addCommand(UserTransfer::class);
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