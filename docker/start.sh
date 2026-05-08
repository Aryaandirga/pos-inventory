#!/bin/bash

# Cache Laravel config
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Run migrations
php artisan migrate --force

# Start PHP-FPM
php-fpm -D

# Start Nginx
nginx -g "daemon off;"