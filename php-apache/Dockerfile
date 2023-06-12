FROM php:7.4-apache

WORKDIR /var/www/html/dependencies

RUN apt-get update && \
    apt-get install -y git curl zip unzip nano mlocate libjpeg62-turbo-dev libpng-dev libfreetype6-dev && \
    updatedb

RUN docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install pdo pdo_mysql gd

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

RUN composer require phpmailer/phpmailer league/oauth2-google

WORKDIR /var/www/html/

COPY ./src .

RUN mkdir ../config

COPY ./config ../config

RUN chown -R www-data:www-data /var/www/html/Assets
RUN chmod -R 777 /var/www/html/Assets
RUN chmod -R 777 /var/www/html/Assets/img/resized_shoes
RUN chmod 777 /var/www/html/data/log.txt

EXPOSE 8080

CMD ["apache2-foreground"]
