FROM php:8.1-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpng-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install gd

# Add configuration to disable short_open_tag
RUN echo "short_open_tag = Off" >> /usr/local/etc/php/php.ini

WORKDIR /var/www/bioleet

RUN chown -R www-data:www-data /var/www/bioleet \
    && chmod -R 777 /var/www/bioleet \
    && chown -R www-data:www-data /var/www/bioleet/public \
    && chmod -R 777 /var/www/bioleet/public

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y nano procps

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN git config --global user.email "turki.fekher@gmail.com" \ 
    && git config --global user.name "Fekher Turki" \
    && git config --global --add safe.directory /var/www/bioleet