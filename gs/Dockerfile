FROM php:7.4-fpm AS base

USER root
# Install PHP extension's dependencies
RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get install -y --no-install-recommends \
    wget \
    git \
    zip \
    unzip \
    libzip-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install zip \
    && rm -rf /tmp/pear
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY conf/php.ini /usr/local/etc/php/conf.d/z-custom.ini
EXPOSE 8000
WORKDIR /app/epidemicpoker/
CMD ["php", "index.php"]

FROM base AS prod
RUN docker-php-ext-install opcache \
    && rm -rf /tmp/pear
COPY ./src /app/epidemicpoker
RUN composer install --optimize-autoloader

FROM base AS dev
# Install Blackfire (Optional)
ARG GS_BLACKFIRE_ACTIVE=0
RUN if [ "$GS_BLACKFIRE_ACTIVE" -eq 1 ] ; then \
	version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire_agent:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz \
    ; fi
# Install XDebug (Optional)
ARG GS_XDEBUG_ACTIVE=0
ENV PHP_IDE_CONFIG serverName=epidemicpoker
RUN if [ "$GS_XDEBUG_ACTIVE" -eq 1 ] ; then \
        yes | pecl install xdebug \
        && rm -rf /tmp/pear \
        && docker-php-ext-enable xdebug \
        && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_host=docker.host.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.idekey=EPIDEMICPOKER-DEBUG" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    ; fi
COPY entrypoint_dev.sh /app/entrypoint.sh
ENTRYPOINT ["/app/entrypoint.sh"]
CMD ["php", "index.php"]