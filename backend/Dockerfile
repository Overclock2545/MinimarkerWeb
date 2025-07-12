FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el código fuente
COPY . /var/www/html

# Establece permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Copia configuración de Apache
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# ⚠️ NUEVO: comandos a ejecutar en build (no fallarán porque composer ya estará antes)
RUN cd /var/www/html && \
    composer install --no-dev --optimize-autoloader && \
    php artisan config:clear && \
    php artisan config:cache && \
    php artisan storage:link

# Comando para arrancar Apache
CMD ["apache2-foreground"]
