FROM php:7.0-apache 

MAINTAINER Carlos Thurber B.

RUN docker-php-ext-install mysqli

WORKDIR /var/www/html/



