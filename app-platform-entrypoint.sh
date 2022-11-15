#!/usr/bin/env bash

set -euo pipefail

psql postgresql://${DB_MAIN_USERNAME}:${DB_MAIN_PASSWORD}@${DB_MAIN_ADDRESS}:${DB_MAIN_PORT} \
    -c 'CREATE DATABASE mydb;' || echo 'Database already exists'

# Perform the database migration
php artisan migrate --force

# Start the server
php artisan serve --host=0.0.0.0 --port=8080
