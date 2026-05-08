#!/bin/bash

# Clear all cache first
php artisan config:clear
php artisan cache:clear

# Cache Laravel config
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Run migrations
php artisan migrate --force

# Storage link & permissions
php artisan storage:link
chmod -R 775 /var/www/storage /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM
php-fpm -D

# Start Nginx
nginx -g "daemon off;"