<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\WebRoot\git\Think.Admin.git\trunk/application/index\view\index.index.html";i:1486969785;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台首页</title>
</head>
<body>
框架版本：<?php echo THINK_VERSION; ?>
<br/>
系统类型：<?php echo php_uname('s'); ?>
<br/>
运行环境：<?php echo php_sapi_name(); ?>
<br/>
PHP版本：<?php echo phpversion(); ?>
<br/>
MySQL版本：<?php echo $mysql_ver; ?>
<br/>
上传限制：<?php echo ini_get('upload_max_filesize'); ?>
<br/>
POST限制：<?php echo ini_get('post_max_size'); ?>
</body>
</html>