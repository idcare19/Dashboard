#!/usr/bin/env sh
set -eu

PORT="${PORT:-8000}"

php artisan optimize:clear || true
php artisan migrate --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec php -S 0.0.0.0:"${PORT}" -t public
