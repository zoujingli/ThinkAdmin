<?php

use think\Console;

Console::starting(function (Console $console) {
    $console->addCommands([
        'app\wechat\command\fans\fansAll',
        'app\wechat\command\fans\fansBlack',
        'app\wechat\command\fans\fansList',
        'app\wechat\command\fans\fansTags',
    ]);
});