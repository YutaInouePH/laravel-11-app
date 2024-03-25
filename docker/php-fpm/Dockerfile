#
# version: 0.1.3
# このファイルが変更されていたらcodeBuildで新しくイメージが作られる
#
FROM php:8.3-fpm-bullseye as base

RUN apt-get update && apt-get install -y \
    # git \
    curl \
    zip \
    unzip \
    libxml2-dev \
    # cron \
    supervisor \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    tzdata \
    libonig-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    postgresql \
    # imagemagick libmagickwand-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) \
    opcache \
    pdo_mysql \
    pgsql \
    pdo_pgsql \
    mbstring \
    xml \
    curl \
    session \
    iconv \
    gd \
    exif \
    zip \
  && pecl install redis \
  && docker-php-ext-enable redis.so \
  && docker-php-source delete

COPY --from=composer:2.5.8 /usr/bin/composer /usr/local/bin/composer

RUN rm /etc/localtime \
  && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

#cron
# ADD ./conf/crontabs /var/spool/cron/crontabs/
# RUN chmod 600 /var/spool/cron/crontabs/*

RUN apt-get update && apt-get install -y vim procps \
&& apt-get clean \
&& rm -rf /var/lib/apt/lists/*

# Set Supervisor Configs
COPY ./conf/supervisord.conf /etc/supervisord.conf

COPY ./conf/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

WORKDIR /var/www
# USER www-data

CMD sh -c 'supervisord -c /etc/supervisord.conf'

FROM base as local
FROM base as ec2
