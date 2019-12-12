<?php

use think\Console;

Console::starting(function (Console $console) {
    $console->addCommand('app\wechat\command\Fans');
});