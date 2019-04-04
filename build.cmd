@echo off
@rmdir /s/q vendor thinkphp
composer update --profile --prefer-dist --optimize-autoloader
composer dump-autoload --optimize