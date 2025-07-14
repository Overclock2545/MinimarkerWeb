FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copia todo el proyecto
COPY . .

# Establece permisos necesarios
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Habilita mod_rewrite para Laravel
RUN a2enmod rewrite

# Copia configuración de Apache personalizada
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Ejecuta comandos necesarios al levantar el contenedor
CMD bash -c "php artisan config:clear && \
             php artisan config:cache && \
             php artisan route:cache && \
             php artisan view:cache && \
             php artisan migrate --force && \
             php artisan storage:link && \
             apache2-foreground"
