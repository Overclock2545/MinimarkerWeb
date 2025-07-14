FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia todo el proyecto
COPY . .

# Permisos necesarios
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Habilita mod_rewrite
RUN a2enmod rewrite

# Configuración personalizada de Apache
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Instala dependencias de Composer sin scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Comandos a ejecutar cuando el contenedor se levanta (producción)
CMD bash -c "php artisan config:clear && \           
             php artisan package:discover --ansi && \
             php artisan config:cache && \
             php artisan route:cache && \
             php artisan view:cache && \
             php artisan migrate --force && \
             php artisan storage:link && \
             apache2-foreground"
