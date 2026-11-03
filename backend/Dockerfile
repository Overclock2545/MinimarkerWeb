FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js postcss.config.js tailwind.config.js ./
RUN npm run build

FROM php:8.2-apache

# Instala extensiones necesarias de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia todo el proyecto Laravel al contenedor
COPY . .
COPY --from=assets /app/public/build ./public/build

# Asigna los permisos correctos
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Copia configuración de Apache personalizada
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Instala dependencias de Composer SIN ejecutar scripts (evita errores durante build)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Preparar Laravel y configurar el puerto al iniciar.
CMD ["bash", "docker/start.sh"]
