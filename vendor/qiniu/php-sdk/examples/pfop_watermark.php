<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;
use Qiniu\Processing\PersistentFop;

//对已经上传到七牛的视频发起异步转码操作 

$accessKey = 'Access_Key';
$secretKey = 'Secret_Key';
$auth = new Auth($accessKey, $secretKey);

//要转码的文件所在的空间和文件名。
$bucket = 'Bucket_Name';
$key = 'File_Name_On_Qiniu';

//转码是使用的队列名称。 https://portal.qiniu.com/mps/pipeline
$pipeline = 'pipeline_name';

//转码完成后通知到你的业务服务器。
$notifyUrl = 'http://375dec79.ngrok.com/notify.php';
$pfop = new PersistentFop($auth, $bucket, $pipeline, $notifyUrl);

//需要添加水印的图片UrlSafeBase64
//可以参考http://developer.qiniu.com/code/v6/api/dora-api/av/video-watermark.html
$base64URL = Qiniu\base64_urlSafeEncode('http://developer.qiniu.com/resource/logo-2.jpg');

//水印参数
$fops = "avthumb/mp4/s/640x360/vb/1.4m/image/".$base64URL;

list($id, $err) = $pfop->execute($key, $fops);
echo "\n====> pfop avthumb result: \n";
if ($err != null) {
    var_dump($err);
} else {
    echo "PersistentFop Id: $id\n";
}

//查询转码的进度和状态
list($ret, $err) = $pfop->status($id);
echo "\n====> pfop avthumb status: \n";
if ($err != null) {
    var_dump($err);
} else {
    var_dump($ret);
}
