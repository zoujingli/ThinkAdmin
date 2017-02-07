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

//将文件从文件$key 复制到文件$key2。 可以在不同bucket复制
$key2 = 'php-logo2.png';
$err = $bucketMgr->copy($bucket, $key, $bucket, $key2);
echo "\n====> copy $key to $key2 : \n";
if ($err !== null) {
    var_dump($err);
} else {
    echo "Success!";
}

//将文件从文件$key2 移动到文件$key3。 可以在不同bucket移动
$key3 = 'php-logo3.png';
$err = $bucketMgr->move($bucket, $key2, $bucket, $key3);
echo "\n====> move $key2 to $key3 : \n";
if ($err !== null) {
    var_dump($err);
} else {
    echo "Success!";
}

//删除$bucket 中的文件 $key
$err = $bucketMgr->delete($bucket, $key3);
echo "\n====> delete $key3 : \n";
if ($err !== null) {
    var_dump($err);
} else {
    echo "Success!";
}
