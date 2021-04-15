FROM php:8.0-apache

ARG UID
ARG GID

COPY . /var/www/html
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/start.sh /usr/local/bin/start

RUN chown -R www-data:www-data /var/www/html/ \
    && chmod u+x /usr/local/bin/start \
    && chmod -R 755 /var/www/html/storage \
    && a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql

RUN usermod -u ${UID} www-data \
    && groupmod -g ${GID} www-data

RUN ln -sf /proc/1/fd/1 /var/log/laravel-scheduler.log

CMD ["/usr/local/bin/start"]
