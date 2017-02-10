:: Composer 安装更新脚本
@title Composer Install
@rmdir /s/q vendor thinkphp
@echo ========= 下载并安装插件 =========
@composer update --profile --prefer-dist --optimize-autoloader
@echo ========= 压缩并发布插件 =========
@composer dump-autoload --optimize
pause