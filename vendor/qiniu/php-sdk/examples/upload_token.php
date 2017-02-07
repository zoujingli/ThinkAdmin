<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;

$accessKey = 'Access_Key';
$secretKey = 'Secret_Key';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'Bucket_Name';
$upToken = $auth->uploadToken($bucket);

echo $upToken;
