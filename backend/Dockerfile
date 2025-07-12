FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el código de la app
COPY . /var/www/html

# Establece permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Habilita mod_rewrite
RUN a2enmod rewrite

# Configura Apache
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Crea enlace simbólico
RUN php artisan storage:link

# ⚠️ Comando de arranque final
CMD composer install && php artisan config:cache && apache2-foreground
