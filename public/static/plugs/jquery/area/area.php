<?php

header('content-type:application/json');

$items = [];
$url = 'https://apis.map.qq.com/ws/district/v1/list?key=AVDBZ-VXMC6-VD2SU-M7DX2-TGSV7-WVF3U';
$result = json_decode(file_get_contents($url), true)['result'];

foreach ($result[0] as $pro) {
    $items[$pro['id']] = ['name' => $pro['fullname'], 'list' => []];
}

foreach ($result[1] as $city) {
    $pkey = substr($city['id'], 0, 2) . '0000';
    if (substr($city['id'], 4, 2) > 0) {
        $ckey = substr($city['id'], 0, 4) . '00';
        $items[$pkey]['list'][$ckey]['name'] = $items[$pkey]['name'];
        $items[$pkey]['list'][$ckey]['list'][$city['id']] = ['name' => $city['fullname'], 'list' => []];
    } else {
        $items[$pkey]['list'][$city['id']] = ['name' => $city['fullname'], 'list' => []];
    }
}

foreach ($result[2] as $area) {
    $ckey = substr($area['id'], 0, 4) . '00';
    $pkey = substr($area['id'], 0, 2) . '0000';
    $items[$pkey]['list'][$ckey]['list'][$area['id']] = ['name' => $area['fullname'], 'list' => []];
}

$data = [];
foreach ($items as $citys) {
    $lines = [];
    foreach ($citys['list'] as $area) {
        $lines[] = $area['name'] . ',' . join(',', array_column($area['list'], 'name'));
    }
    $data[] = $citys['name'] . '$' . join('|', $lines);
}

$filename = dirname(__DIR__) . '/pcasunzips.js';
$content = str_replace('__STRING__', join('#', $data), file_get_contents(__DIR__ . '/area.js'));

if (file_put_contents($filename, $content)) {
    echo 'success';
} else {
    echo 'error';
}