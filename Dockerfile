FROM php:8.3-fpm


RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libpng-dev libonig-dev libxml2-dev zip libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


WORKDIR /var/www/html

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} deploy \
    && useradd -u ${UID} -g deploy -m deploy \
    && usermod -aG www-data deploy \
    && chown -R deploy:deploy /var/www/html

USER deploy


COPY --chown=www-data:www-data . ./


RUN composer install --no-dev --optimize-autoloader


RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]
