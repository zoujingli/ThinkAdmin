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

//将文件从文件$key 改成文件名$key2。 可以在不同bucket移动
$key3 = 'php-logo3.png';
$err = $bucketMgr->move($bucket, $key2, $bucket, $key3);
echo "\n====> move $key to $key2 : \n";
if ($err !== null) {
    var_dump($err);
} else {
    echo "Success!";
}
