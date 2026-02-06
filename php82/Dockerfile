ARG ALPINE_VERSION=3.20
ARG PHP_VERSION=82
ARG APP_USER=www-data
ARG APP_GROUP=www-data

FROM alpine:${ALPINE_VERSION}

ARG PHP_VERSION
ARG APP_USER
ARG APP_GROUP

LABEL Maintainer="nooblk-98"
LABEL Description="Lightweight container with Nginx & PHP-FPM based on Alpine Linux (PHP 8.2)."
LABEL Version="3.0"

ENV PHP_VERSION=${PHP_VERSION} \
    PHP_INI_DIR=/etc/php${PHP_VERSION} \
    PHP_FPM_BIN=php-fpm${PHP_VERSION} \
    PHP_BIN=php${PHP_VERSION} \
    APP_USER=${APP_USER} \
    APP_GROUP=${APP_GROUP}

WORKDIR /var/www/html

RUN apk add --no-cache \
  ca-certificates \
  curl \
  nginx \
  openssl \
  tini \
  supervisor \
  php${PHP_VERSION} \
  php${PHP_VERSION}-common \
  php${PHP_VERSION}-ctype \
  php${PHP_VERSION}-curl \
  php${PHP_VERSION}-dom \
  php${PHP_VERSION}-fileinfo \
  php${PHP_VERSION}-fpm \
  php${PHP_VERSION}-gd \
  php${PHP_VERSION}-intl \
  php${PHP_VERSION}-iconv \
  php${PHP_VERSION}-mbstring \
  php${PHP_VERSION}-mysqli \
  php${PHP_VERSION}-opcache \
  php${PHP_VERSION}-openssl \
  php${PHP_VERSION}-phar \
  php${PHP_VERSION}-session \
  php${PHP_VERSION}-simplexml \
  php${PHP_VERSION}-tokenizer \
  php${PHP_VERSION}-xml \
  php${PHP_VERSION}-xmlreader \
  php${PHP_VERSION}-xmlwriter \
  php${PHP_VERSION}-zip \
  php${PHP_VERSION}-pecl-apcu \
  php${PHP_VERSION}-pecl-redis \
  && ln -sf /usr/bin/php${PHP_VERSION} /usr/bin/php

RUN set -eux; \
  if ! grep -q "^${APP_GROUP}:" /etc/group; then addgroup -S "${APP_GROUP}"; fi; \
  if ! id -u "${APP_USER}" >/dev/null 2>&1; then adduser -S -G "${APP_GROUP}" "${APP_USER}"; fi; \
  install -d -o "${APP_USER}" -g "${APP_GROUP}" /run/nginx /run/php /run/supervisor /var/lib/nginx /var/log/nginx /var/cache/nginx /var/www/html

COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/conf.d /etc/nginx/conf.d/

COPY supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY php/fpm-pool.conf ${PHP_INI_DIR}/php-fpm.d/www.conf
COPY php/php.ini ${PHP_INI_DIR}/conf.d/99-custom.ini
RUN echo "allow_url_fopen = On" > ${PHP_INI_DIR}/conf.d/98-allow_url_fopen.ini

RUN chown -R ${APP_USER}:${APP_GROUP} /var/www/html /run/nginx /run/php /run/supervisor /var/lib/nginx /var/log/nginx /var/cache/nginx

USER ${APP_USER}

COPY --chown=${APP_USER}:${APP_GROUP} src/ /var/www/html/

EXPOSE 8080

ENTRYPOINT ["/sbin/tini","--"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping || exit 1
