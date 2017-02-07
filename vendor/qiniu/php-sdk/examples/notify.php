<?php

// 获取notify通知的body信息
$notifyBody = file_get_contents('php://input');

// 业务服务器处理通知信息， 这里直接打印在log中
error_log($notifyBody);
