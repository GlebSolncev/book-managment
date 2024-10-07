#!/bin/sh

echo "Composer installing"
composer install --no-interaction --prefer-dist --optimize-autoloader
chown -R www-data:www-data /var/www/book

echo "Copy env"
cp .env.example .env

echo "Key generate"
php artisan key:generate

echo "Migration"
php artisan migrate --force

echo "Clear cache"
php artisan opti:clear

echo "Testing and make coverage"
php -d pcov.enabled=1 vendor/bin/phpunit --coverage-text --coverage-html=coverage-html

echo "Generate swagger documentation"
php artisan l5-swagger:generate

php artisan db:seed BookSeeder
chown -R www-data:www-data /var/www/book

