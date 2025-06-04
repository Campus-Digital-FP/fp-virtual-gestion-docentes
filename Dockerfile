# Usar PHP 8.1 con FPM
FROM php:8.1-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx supervisor && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node.js y compilar assets
RUN npm install && npm run build

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Configuración de Nginx
COPY <<EOF /etc/nginx/sites-available/default
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php index.html index.htm;

    location / {
        try_files \\$uri \\$uri/ /index.php?\\$query_string;
    }

    location ~ \\.php\\$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \\$document_root\\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\\.ht {
        deny all;
    }
}
EOF

# Configuración de Supervisor
COPY <<EOF /etc/supervisor/conf.d/supervisord.conf
[supervisord]
nodaemon=true
user=root
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid

[program:php-fpm]
command=php-fpm8.1 -F
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
autorestart=false
startretries=0

[program:nginx]
command=nginx -g 'daemon off;'
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
autorestart=false
startretries=0
EOF

# Script de inicio
COPY <<EOF /start.sh
#!/bin/bash

# Generar clave de aplicación si no existe
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generar clave de aplicación
php artisan key:generate --force

# Ejecutar migraciones si la base de datos está disponible
php artisan migrate --force

# Optimizar configuración para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
EOF

RUN chmod +x /start.sh

# Exponer puerto 80
EXPOSE 80

# Comando de inicio
CMD ["/start.sh"]