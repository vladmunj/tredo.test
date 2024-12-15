#!/bin/bash

# Clear app cache
php artisan cache:clear

# Generate new app key
php artisan key:generate

# Run migrations
php artisan migrate

# Run next commands script executed
exec "$@"
