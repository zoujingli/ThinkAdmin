@echo off
title Composer Plugs Update and Optimize
echo.
echo ========= 1. 清理已安装插件 =========
@rmdir /s/q vendor thinkphp
echo.
echo ========= 2. 下载并安装插件 =========
composer update --profile --prefer-dist --optimize-autoloader
echo.
echo ========= 3. 压缩并发布插件 =========
composer dump-autoload --optimize
exit