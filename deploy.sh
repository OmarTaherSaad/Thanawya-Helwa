#!/bin/sh
# activate maintenance mode
php artisan down
# update source code
git pull
# update PHP dependencies
export HOME=/root && export COMPOSER_HOME=/root && /usr/local/bin/ea-php72 -d memory_limit=-1 /usr/local/bin/composer update
# --no-interaction Do not ask any interactive question
# --no-dev  Disables installation of require-dev packages.
# --prefer-dist  Forces installation from package dist even for dev versions.
# update database
php artisan migrate --force
#Update config & cache
php artisan config:cache
# --force  Required to run when in production.
# stop maintenance mode
php artisan up
