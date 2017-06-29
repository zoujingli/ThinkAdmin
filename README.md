Think.Admin
---

`Think.Admin`是一个基于`Thinkphp5`开发的后台管理系统，集成后台系统常用功能。

项目安装请参考`ThinkPHP`官方文档及下面的服务环境说明，数据库`sql`文件存放于项目根目录下。

注意：项目测试请另行搭建环境并创建数据库（数据库配置`application/database.php`）, 切勿直接使用测试环境数据！

`Think.Admin`及`微信开发`技术交流QQ群
[![QQ群](http://pub.idqqimg.com/wpa/images/group.png "QQ群")](http://shang.qq.com/wpa/qunwpa?idkey=ae25cf789dafbef62e50a980ffc31242f150bc61a61164458216dd98c411832a)

**`Think.Admin`开发手册 ( 撰写中 )** : http://doc.think.ctolog.com

`Think.Admin`已集成模块
---
* 简易`RBAC`权限管理（用户、权限、节点、菜单控制）
* 自建秒传文件上载组件（本地存储、七牛云存储，阿里云OSS存储）
* 基站数据服务组件（唯一随机序号、表单更新）
* `Http`服务组件（原生`CURL`封装，兼容PHP多版本）
* 微信公众号服务组件（基于[wechat-php-sdk](https://github.com/zoujingli/wechat-php-sdk)，微信网页授权获取用户信息、已关注粉丝管理、自定义菜单管理等等）
* 微信商户支付服务组件（基于[wechat-php-sdk](https://github.com/zoujingli/wechat-php-sdk)，支持JSAPI支付、扫码模式一支付、扫码模式二支付）
* 测试公众号名称：思过崖思过 （大家可以关注它来进行简单的测试）
* 更多组件开发中...


服务器环境
---
* `PHP`版本不低于`PHP5.4`，推荐使用`PHP7`以达到最优效果
* 项目运行需支持`PATHINFO`，项目不支持`ThinkPHP`的`URL`兼容模式运行（源于如何优雅的展示）
* `Apache`：已在项目根目录加入`.htaccess`文件，只需开启`rewrite`模块

```xml
<IfModule mod_rewrite.c>
  Options +FollowSymlinks -Multiviews
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
```

* `Nginx`：配置参考下面的`demo`代码

```
server {
	listen 80;
	server_name wealth.demo.cuci.cc;
	root /home/wwwroot/Think.Admin;
	index index.php index.html index.htm;
	
	add_header X-Powered-Host $hostname;
	fastcgi_hide_header X-Powered-By;
	
	if (!-e $request_filename) {
		rewrite  ^/(.+?\.php)/?(.*)$  /$1/$2  last;
		rewrite  ^/(.*)$  /index.php/$1  last;
	}
	
	location ~ \.php($|/){
		fastcgi_index   index.php;
		fastcgi_pass    127.0.0.1:9000;
		include         fastcgi_params;
		set $real_script_name $fastcgi_script_name;
		if ($real_script_name ~ "^(.+?\.php)(/.+)$") {
			set $real_script_name $1;
		}
		fastcgi_split_path_info ^(.+?\.php)(/.*)$;
		fastcgi_param   PATH_INFO               $fastcgi_path_info;
		fastcgi_param   SCRIPT_NAME             $real_script_name;
		fastcgi_param   SCRIPT_FILENAME         $document_root$real_script_name;
		fastcgi_param   PHP_VALUE               open_basedir=$document_root:/tmp/:/proc/;
		access_log      /home/wwwlog/domain_access.log    access;
		error_log       /home/wwwlog/domain_error.log     error;
	}
	
	location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$ {
		access_log  off;
		error_log   off;
		expires     30d;
	}
	
	location ~ .*\.(js|css)?$ {
		access_log   off;
		error_log    off;
		expires      12h;
	}
}
```
