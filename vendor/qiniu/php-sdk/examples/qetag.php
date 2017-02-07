<?php
require_once __DIR__ . '/../autoload.php';
use Qiniu\Etag;

list($etag, $err) = Etag::sum(__file__);
if ($err == null) {
    echo  "Etag: $etag";
} else {
    var_dump($err);
}
