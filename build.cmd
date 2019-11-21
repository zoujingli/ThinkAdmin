@echo off
@rmdir /s/q vendor thinkphp
composer update --profile --prefer-dist --no-dev --optimize-autoloader