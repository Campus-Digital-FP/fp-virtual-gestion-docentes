#!/bin/bash

cd /var/www/html

# Generar archivo .env si no existe
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones si la base de datos está disponible
php artisan migrate --seed || true

# Optimizar configuración para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf