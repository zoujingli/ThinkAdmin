<?php

$data = [];
$list = json_decode(file_get_contents(__DIR__ . '/area.json'), true);
foreach ($list as $citys) {
    $lines = [];
    foreach ($citys['list'] as $area) {
        $lines[] = $area['name'] . ',' . join(',', $area['list']);
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