#!/bin/bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
LANG=en_US.UTF-8

export PATH

echo "
+----------------------------------------------------------------------
| ThinkAdmin environmental preparation tools
+----------------------------------------------------------------------
| GtiHub   : https://github.com/zoujingli/ThinkAdmin
+----------------------------------------------------------------------
| document : https://www.kancloud.cn/zoujingli/thinkadmin/323614
+----------------------------------------------------------------------
"

hasComposer=`command -v composer`

echo -e "\033[34mConfirm the existence of the command....\033[0m"

if [ ! -f "${hasComposer}" ]; then
echo -e "\033[31mComposer Not Found! Initialization cannot continue. \033[0m"
exit
fi

echo -e "\033[34mClean up the running environment....\033[0m"
rm -rf ./vendor
rm -rf ./thinkphp
rm -rf ./composer.lock

echo -e "\033[34mComposer install....\033[0m"
composer install --profile --prefer-dist --optimize-autoloader

echo -e "\033[34mMake Autoload....\033[0m"
composer dump-autoload --optimize

echo -e "\033[31mEnvironmental preparation success!\033[0m"