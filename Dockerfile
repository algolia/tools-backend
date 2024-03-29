FROM php:7.4

RUN apt update -y && apt install -y openssl zip unzip git libpq-dev postgresql-client

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# PHP Extensions
RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /app
COPY . /app

# Composer dependencies
RUN composer install

# Migrate & Start web server
CMD ["/app/app-platform-entrypoint.sh"]

EXPOSE 8080
