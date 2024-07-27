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
#ENV FRANKENPHP_CONFIG="worker ./public/index.php"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
COPY . /app
COPY ./docker/caddy/Caddyfile /etc/caddy/Caddyfile

RUN apt-get update && apt-get -y upgrade && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
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
    docker-php-ext-enable redis &&\sed -i "s/CipherString = .*$/#CipherString/" /etc/ssl/openssl.cnf
# Copy the PHP files of your project in the public directory
RUN if [ "$BUILD_APP_ENV" = "local" ]; then pecl install xdebug && docker-php-ext-enable xdebug && pear config-set php_ini /usr/local/etc/php/php.ini; fi

RUN mv "$(pwd)/docker/$BUILD_APP_ENV/php.ini" "$PHP_INI_DIR/php.ini"

RUN php artisan optimize

COPY ./docker/supervisor/conf.d /etc/supervisor/conf.d
RUN if [ "${CONTAINER_ROLE}" = "scheduler" ]; then service supervisor stop && service supervisor start  && supervisorctl reread && supervisorctl update && service supervisor restart horizon; fi


#ARG USER=www-data
#
#RUN \
#	# Use "adduser -D ${USER}" for alpine based distros
#	useradd -D ${USER}; \
#	# Add additional capability to bind to port 80 and 443
#	setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp; \
#	# Give write access to /data/caddy and /config/caddy
#	chown -R ${USER}:${USER} /data/caddy && chown -R ${USER}:${USER} /config/caddy && \
#    chown -R ${USER}:${USER} /app
#
#USER ${USER}
