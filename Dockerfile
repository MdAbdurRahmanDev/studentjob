FROM dunglas/frankenphp:php8.3

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 80

CMD ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=80"]
# Update Nginx to serve from the public directory
RUN sed -i 's!root /app;!root /app/public;!g' /etc/nginx/sites-available/default || true
RUN sed -i 's!root /var/www/html;!root /var/www/html/public;!g' /etc/nginx/sites-available/default || true
RUN sed -i 's!root /var/www/html;!root /var/www/html/public;!g' /etc/nginx/conf.d/default.conf || true
