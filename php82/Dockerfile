ARG ALPINE_VERSION=3.21
FROM alpine:${ALPINE_VERSION}
LABEL Maintainer="nooblk-98"
LABEL Description="Lightweight container with Nginx & PHP based on Alpine Linux."
LABEL Version="1.0"
# Setup document root
WORKDIR /var/www/html

# Install packages and remove default server definition
RUN apk add --no-cache \
  curl \
  nginx \
  php84 \
  supervisor

# PHP extension installer
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install required PHP extensions
RUN install-php-extensions gd \
    xdebug \
    pcntl \
    redis \
    mysqli \
    pdo \
    pdo_mysql \
    mbstring \
    curl \
    xml \
    zip \
    json \
    fileinfo \
    dom \
    opcache \
    phar \
    iconv \
    tokenizer \
    simplexml \
    intl \
    exif \
    imagick \
    soap \
    bcmath

# RUN ln -s /usr/bin/php84 /usr/bin/php

# # Configure nginx - http
# COPY config/nginx.conf /etc/nginx/nginx.conf
# # Configure nginx - default server
# COPY config/conf.d /etc/nginx/conf.d/

# # Configure PHP-FPM
# ENV PHP_INI_DIR /etc/php84
# COPY config/fpm-pool.conf ${PHP_INI_DIR}/php-fpm.d/www.conf
# COPY config/php.ini ${PHP_INI_DIR}/conf.d/custom.ini

# # Configure supervisord
# COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# # Make sure files/folders needed by the processes are accessable when they run under the nobody user
# RUN chown -R nobody:nobody /var/www/html /run /var/lib/nginx /var/log/nginx

# # Switch to use a non-root user from here on
# USER nobody

# # Add application
# COPY --chown=nobody src/ /var/www/html/

# # Expose the port nginx is reachable on
# EXPOSE 8080

# # Let supervisord start nginx & php-fpm
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# # Configure a healthcheck to validate that everything is up&running
# HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping || exit 1