FROM trafex/php-nginx:latest
USER root
# Install Laravel framework system requirements (https://laravel.com/docs/8.x/deployment#optimizing-configuration-loading)
RUN apk update && apk upgrade
RUN apk add oniguruma-dev postgresql-dev libxml2-dev
# Copy Composer binary from the Composer official Docker image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV production
WORKDIR /app
COPY . .
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-req=ext-tokenizer --ignore-platform-req=ext-fileinfo  --ignore-platform-req=php --ignore-platform-req=ext-zip
# Optimizing Configuration loading
RUN php artisan route:clear
RUN artisan route:cache
RUN php artisan config:cache
# Optimizing Route loading
RUN php artisan route:cache
# Optimizing View loading
RUN php artisan view:cache

RUN chown -R application:application .
USER application