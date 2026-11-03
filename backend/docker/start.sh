#!/usr/bin/env bash
set -eu

port="${PORT:-10000}"
case "$port" in
    ''|*[!0-9]*) echo 'PORT debe ser un número de puerto válido.' >&2; exit 1 ;;
esac
if [ "$port" -lt 1 ] || [ "$port" -gt 65535 ]; then
    echo 'PORT debe estar entre 1 y 65535.' >&2
    exit 1
fi

sed -i "s/^Listen 80$/Listen ${port}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${port}>/" /etc/apache2/sites-available/000-default.conf

php artisan config:clear --ansi
php artisan package:discover --ansi
php artisan config:cache --ansi
php artisan route:cache --ansi
php artisan view:cache --ansi

exec apache2-foreground
