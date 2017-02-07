<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

$accessKey = 'Access_Key';
$secretKey = 'Secret_Key';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'Bucket_Name';
// 在七牛保存的文件名
$key = 'php-logo.png';
$token = $auth->uploadToken($bucket);
$uploadMgr = new UploadManager();

//上传视频，上传完成后进行m3u8的转码， 并给视频打水印
$wmImg = Qiniu\base64_urlSafeEncode('http://Bucket_Name.qiniudn.com/logo-s.png');
$pfop = "avthumb/m3u8/wmImage/$wmImg";

//转码完成后通知到你的业务服务器。（公网可以访问，并相应200 OK）
$notifyUrl = 'http://notify.fake.com';

//独立的转码队列：https://portal.qiniu.com/mps/pipeline
$pipeline = 'pipeline_name';

$policy = array(
    'persistentOps' => $pfop,
    'persistentNotifyUrl' => $notifyUrl,
    'persistentPipeline' => $pipeline
);
$token = $auth->uploadToken($bucket, null, 3600, $policy);

list($ret, $err) = $uploadMgr->putFile($token, null, $key);
echo "\n====> putFile result: \n";
if ($err !== null) {
    var_dump($err);
} else {
    var_dump($ret);
}
