@echo off
@rmdir /s/q vendor
composer update --profile --prefer-dist --optimize-autoloader
composer dump-autoload --optimize
