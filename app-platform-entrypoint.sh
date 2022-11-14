#!/usr/bin/env bash

set -euo pipefail

# Perform the database migration
php artisan migrate --force

# Start the server
php artisan serve --host=0.0.0.0 --port=8080
