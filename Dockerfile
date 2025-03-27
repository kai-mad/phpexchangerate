ARG PHP_VERSION=8.3
ARG COMPOSER_VERSION=2.8.6

# -------------------- php-server --------------------- #

FROM --platform=linux/x86_64 php:${PHP_VERSION}-cli AS php-server

ARG COMPOSER_VERSION


RUN set -x \
 && mkdir -p /var/www/html

RUN set -x \
 && apt-get update && apt-get install -y \
    wget \
    git \
    unzip \
    libpng-dev \
    libzip-dev \
    python  \
    rsync \
    \
 && curl https://bootstrap.pypa.io/pip/2.7/get-pip.py | python \
 && easy_install pip \
 && python -m pip install 'fabric<2.0' \
 && docker-php-ext-install \
    mysqli \
    gd \
    zip \
    opcache \
    \
 && EXPECTED_CHECKSUM="$(wget -q -O - https://composer.github.io/installer.sig)" \
 && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" \
 && if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then \
      echo "ERROR Invalid installer checksum"; \
      rm composer-setup.php; \
      exit 1; \
      fi \
 && php composer-setup.php --version=${COMPOSER_VERSION} \
 && rm composer-setup.php \
 && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

# -------------------- php-app --------------------- #

FROM php-server AS php-app

COPY composer.* .env ./

RUN set -x \
 && composer install --no-interaction


WORKDIR /var/www/html
