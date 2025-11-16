# Base PHP 8.4 FPM
FROM php:8.4-fpm

WORKDIR /var/www/html

# Dependências do sistema e extensões PHP para Laravel
# Instalar dependências do sistema e extensões PHP necessárias para Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip \
    nodejs npm gnupg build-essential libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql mbstring zip exif pcntl bcmath gd


# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código
COPY . /var/www/html

# Copiar .env.production
COPY .env.production /var/www/html/.env

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Build PHP + JS/CSS
RUN composer install --no-dev --optimize-autoloader \
    && npm install --production \
    && npm run build

EXPOSE 9000
CMD ["php-fpm"]
