#!/bin/bash

# Clear app cache
php artisan cache:clear

# Generate new app key
php artisan key:generate

# Run migrations
php artisan migrate

# Listen & execute jobs on specific queues
php artisan queue:work --queue=firebase &

# Run next commands script executed
exec "$@"
