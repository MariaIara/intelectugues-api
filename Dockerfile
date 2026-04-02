FROM php:8.3-fpm-alpine AS base

# Instala dependências do sistema
RUN apk add --no-cache \
    nginx \
    curl \
    zip \
    unzip \
    git \
    supervisor \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxml2-dev \
    postgresql-dev \
    icu-dev \
    $PHPIZE_DEPS

# Instala extensões PHP
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        xml \
        intl \
        opcache

# Instala Redis extension via PECL
RUN pecl install redis && docker-php-ext-enable redis

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configura PHP para produção
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Configura Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Configura Supervisor (gerencia nginx + php-fpm juntos)
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia arquivos do projeto
COPY . .

# Instala dependências PHP (sem dev, otimizado)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Script de entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]