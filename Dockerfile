
FROM alpine:latest

# Install Laravel framework system requirements (https://laravel.com/docs/8.x/deployment#optimizing-configuration-loading)
RUN apk update && apk upgrade
RUN apk add bash
RUN apk add nginx

RUN mkdir /var/run/php
# Copy Composer binary from the Composer official Docker image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV production
WORKDIR /app
COPY composer.json composer.lock
COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev
# Optimizing Configuration loading
RUN php artisan config:cache
# Optimizing Route loading
RUN php artisan route:cache
# Optimizing View loading
RUN php artisan view:cache

RUN chown -R application:application .
CMD ["/bin/bash", "-c", "nginx -g 'daemon off;'"]