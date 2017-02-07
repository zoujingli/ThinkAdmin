<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

$accessKey = 'Access_Key';
$secretKey = 'Secret_Key';

//初始化Auth状态：
$auth = new Auth($accessKey, $secretKey);

//初始化BucketManager
$bucketMgr = new BucketManager($auth);
