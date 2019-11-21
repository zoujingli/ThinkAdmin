@echo off
@rmdir /s/q vendor
composer update --profile --prefer-dist --no-dev --optimize-autoloader