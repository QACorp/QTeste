FROM dunglas/frankenphp

# Be sure to replace "your-domain-name.example.com" by your domain name
ENV SERVER_NAME=:80
# If you want to disable HTTPS, use this value instead:
#ENV SERVER_NAME=:80
ARG BUILD_APP_ENV
ARG DB_CONNECTION=pgsql
ARG DB_HOST=localhost
ARG DB_PORT=5432
ARG DB_DATABASE=qakit
ARG DB_USERNAME=postgres
ARG DB_PASSWORD=postgres
ARG APP_ENV=local
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
COPY . /app

RUN apt-get update && apt-get -y upgrade && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        nano \
        wget \
        libcurl4-gnutls-dev \
        libxml2-dev \
        libpng-dev \
        git \
        libzip-dev \
        supervisor \
        openssl \
        zlib1g-dev \
        libpq-dev && \
     docker-php-ext-install \
        bcmath \
        calendar \
        gd \
        pgsql \
        pdo_pgsql \
        pcntl \
        zip && \
    pecl install redis && \
    docker-php-ext-enable redis &&\sed -i "s/CipherString = .*$/#CipherString/" /etc/ssl/openssl.cnf && \
    chown -R www-data:www-data /app
# Copy the PHP files of your project in the public directory
RUN if [ "$BUILD_APP_ENV" = "local" ]; then pecl install xdebug && docker-php-ext-enable xdebug && pear config-set php_ini /usr/local/etc/php/php.ini; fi

RUN mv "$(pwd)/docker/$BUILD_APP_ENV/php.ini" "$PHP_INI_DIR/php.ini"

RUN php artisan optimize

RUN if [ "$BUILD_APP_ENV" = "production" ]; then php artisan migrate --force; fi
COPY ./docker/supervisor/conf.d /etc/supervisor/conf.d
RUN if [ "${CONTAINER_ROLE}" = "scheduler" ]; then service supervisor stop && service supervisor start  && supervisorctl reread && supervisorctl update && service supervisor restart horizon; fi

