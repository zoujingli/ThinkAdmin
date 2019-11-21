<?php
require 'Ip2Region.php';

$ip2region = new Ip2Region();

$ip = '61.140.232.170';
echo PHP_EOL;
echo "查询IP：{$ip}" . PHP_EOL;
$info = $ip2region->btreeSearch($ip);
var_export($info);

echo PHP_EOL;
$info = $ip2region->memorySearch($ip);
var_export($info);
echo PHP_EOL;

// array (
//     'city_id' => 2163,
//     'region' => '中国|华南|广东省|深圳市|鹏博士',
// )