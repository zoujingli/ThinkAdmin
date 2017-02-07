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

//你要测试的空间， 并且这个key在你空间中存在
$bucket = 'Bucket_Name';
$key = 'php-logo.png';

//获取文件的状态信息
list($ret, $err) = $bucketMgr->stat($bucket, $key);
echo "\n====> $key stat : \n";
if ($err !== null) {
    var_dump($err);
} else {
    var_dump($ret);
}
