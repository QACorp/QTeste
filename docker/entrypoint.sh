#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}
if [ "$1" = "health" ] && [ "$role" = "app" ]; then
    /usr/bin/curl --fail http://nginx/api/health || exit 1
    exit 1
elif [ "$1" = "health" ]; then
    exit 1
fi
if [ "$role" = "app" ]; then
    cd /app
    php artisan view:clear
    php artisan config:clear
    php artisan optimize
    if [ "$env" = "local" ]; then \
        php artisan octane:frankenphp --workers=4 --max-requests=10 --port=80 --host=0.0.0.0 --admin-port=2019 --watch; \
    else \
        php artisan migrate --force
        php artisan octane:frankenphp --workers=4 --max-requests=10 --port=80 --host=0.0.0.0 --admin-port=2019; \
    fi
fi

if [ "$role" = "queue" ]; then
    echo "Queue iniciada."
    php artisan horizon

elif [ "$role" = "scheduler" ]; then

    while [ true ]
    do
      php artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
