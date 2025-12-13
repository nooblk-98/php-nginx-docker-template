ARG ALPINE_VERSION=3.15
ARG PHP_VERSION=7
FROM alpine:${ALPINE_VERSION}
LABEL Maintainer="nooblk-98"
LABEL Description="Lightweight container with Nginx & PHP based on Alpine Linux."
LABEL Version="2.1"

# Setup document root
WORKDIR /var/www/html

# Install packages and remove default server definition
RUN apk add --no-cache \
  curl \
  nginx \
  php${PHP_VERSION} \
  php${PHP_VERSION}-ctype \
  php${PHP_VERSION}-curl \
  php${PHP_VERSION}-dom \
  php${PHP_VERSION}-fileinfo \
  php${PHP_VERSION}-fpm \
  php${PHP_VERSION}-gd \
  php${PHP_VERSION}-intl \
  php${PHP_VERSION}-mbstring \
  php${PHP_VERSION}-mysqli \
  php${PHP_VERSION}-opcache \
  php${PHP_VERSION}-openssl \
  php${PHP_VERSION}-phar \
  php${PHP_VERSION}-session \
  php${PHP_VERSION}-tokenizer \
  php${PHP_VERSION}-xml \
  php${PHP_VERSION}-xmlreader \
  php${PHP_VERSION}-xmlwriter \
  supervisor



RUN ln -sf /usr/bin/php7 /usr/bin/php

# Configure nginx - http
COPY nginx/nginx.conf /etc/nginx/nginx.conf
# Configure nginx - default server
COPY nginx/conf.d /etc/nginx/conf.d/

# Configure supervisord
COPY supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure PHP-FPM
ENV PHP_INI_DIR=/etc/php7
COPY php/fpm-pool.conf ${PHP_INI_DIR}/php-fpm.d/www.conf
COPY php/php.ini ${PHP_INI_DIR}/conf.d/custom.ini

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