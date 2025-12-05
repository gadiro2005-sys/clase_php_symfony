FROM php:8.2-fpm
ARG TIMEZONE

COPY php/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
        libpq-dev \
        libzip-dev \
        libxslt1-dev \
        libonig-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libicu-dev \
        libxml2-dev \
        zlib1g-dev \
        curl

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip xsl gd intl opcache mbstring soap calendar

# Install the cURL extension
RUN apt-get update && apt-get install -y \
    libcurl4 \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl

# SET TIMEZONE FOR PHP
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Install symfony CLI
COPY --link \
    --from=ghcr.io/symfony-cli/symfony-cli:latest \
    /usr/local/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/symfonyapp
EXPOSE 9000
CMD ["php-fpm"]
