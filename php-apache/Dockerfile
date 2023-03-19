FROM php:7.4-apache

WORKDIR /var/www/html/dependencies

RUN apt-get update && \
    apt-get install -y git curl zip unzip nano mlocate && \
    updatedb

RUN docker-php-ext-install pdo pdo_mysql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

RUN composer require phpmailer/phpmailer league/oauth2-google

WORKDIR /var/www/html/

COPY ./src .

RUN mkdir ../includes

COPY ./includes ../includes

RUN chown -R www-data:www-data /var/www/html/Assets
RUN chmod -R 777 /var/www/html/Assets


EXPOSE 8080

CMD ["apache2-foreground"]

