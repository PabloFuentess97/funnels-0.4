FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    gnupg \
    netcat-traditional

# Instalar Node.js y npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar archivos de la aplicación
COPY . /var/www

# Instalar dependencias de PHP
RUN composer install --optimize-autoloader --no-dev

# Instalar dependencias de Node.js y compilar assets
RUN if [ -f "package.json" ]; then \
        npm install && \
        npm run build; \
    fi

# Configurar permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Configurar PHP-FPM
RUN mkdir -p /var/run/php && \
    touch /var/run/php/php8.2-fpm.sock && \
    chown -R www-data:www-data /var/run/php

# Copiar configuraciones
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configurar PHP
RUN echo "php_admin_value[memory_limit] = 256M" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "php_admin_value[post_max_size] = 100M" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "php_admin_value[upload_max_filesize] = 100M" >> /usr/local/etc/php-fpm.d/www.conf

# Exponer puerto
EXPOSE 80

# Comando para iniciar servicios
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
