<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

$accessKey = 'Access_Key';
$secretKey = 'Secret_Key';

$auth = new Auth($accessKey, $secretKey);
$bmgr = new BucketManager($auth);

$url = 'http://php.net/favicon.ico';
$bucket = 'Bucket_Name';
$key = time() . '.ico';

list($ret, $err) = $bmgr->fetch($url, $bucket, $key);
echo "=====> fetch $url to bucket: $bucket  key: $key\n";
if ($err !== null) {
    var_dump($err);
} else {
    echo 'Success';
}
