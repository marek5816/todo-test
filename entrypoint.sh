#!/bin/bash

# Wait for MariaDB to be ready
echo "Waiting for database..."
until nc -z -v -w30 db 3306
do
  echo "Waiting for database connection..."
  sleep 5
done

# Install PHP dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Check if the migrations have already been run by checking if the flag file exists
if [ ! -f /var/www/html/storage/app/migrated ]; then
  # Run database migrations
  php artisan migrate:fresh --force

  # Seed db
  php artisan db:seed
  
  php artisan dusk:install
  rm /var/www/html/tests/Browser/ExampleTest.php

  # Create a flag file to indicate that migrations have been done
  touch /var/www/html/storage/app/migrated
else
  # Just run migrations without seeding
  php artisan migrate --force
fi

# Install NPM dependencies
npm install

# Build assets
npm run dev &

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start supervisord
/usr/bin/supervisord -n
