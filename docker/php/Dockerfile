FROM php:7.4-apache

COPY docker/php/conf/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
COPY docker/php/conf/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/conf/apache-custom-security.conf /etc/apache2/conf-available/zz-custom-security.conf


COPY . /var/www/html

ENV APP_ENV=prod
ENV DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

COPY docker/php/buil_image.sh /buil_image.sh
RUN chmod +x /buil_image.sh && /buil_image.sh
