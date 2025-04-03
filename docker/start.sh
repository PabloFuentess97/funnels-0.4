#!/bin/bash

# Esperar a que MySQL esté listo
echo "Waiting for MySQL to be ready..."
while ! nc -z db 3306; do
  sleep 1
done

cd /var/www

# Limpiar cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generar key si no existe
php artisan key:generate --no-interaction --force

# Ejecutar migraciones
php artisan migrate --force

# Optimizar
php artisan optimize
php artisan route:cache
php artisan config:cache
php artisan view:cache

# Asegurar permisos
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Iniciar servicios
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
