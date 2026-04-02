#!/bin/sh
set -e

echo "==> Copiando .env de exemplo se não existir..."
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

echo "==> Gerando APP_KEY se necessário..."
php artisan key:generate --no-interaction --force

echo "==> Rodando migrations..."
php artisan migrate --force --no-interaction

echo "==> Limpando e aquecendo caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Criando link de storage..."
php artisan storage:link || true

echo "==> Iniciando serviços (nginx + php-fpm)..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf