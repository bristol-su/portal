#!/bin/bash

set -e

env

if [[ -n "$1" ]]; then
    exec "$@"
else
    wait-for-it db:3306 -t 45
    composer install --no-interaction
    php artisan migrate --force --database=mysql
    php artisan passport:keys
    chown -R www-data:www-data storage
    exec apache2-foreground
fi
