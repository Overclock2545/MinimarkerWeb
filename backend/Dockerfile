FROM php:8.2-apache

# Instala extensiones necesarias de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Instala Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el código fuente del proyecto
COPY . .

# Ajusta permisos para Laravel (especialmente para storage y cache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Copia configuración personalizada de Apache
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# ⚠️ Instala dependencias de Laravel, y cachea config/rutas/vistas
RUN composer install --no-dev --optimize-autoloader \
    && php artisan key:generate \
    && php artisan config:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan storage:link

# Inicia Apache
CMD ["apache2-foreground"]
