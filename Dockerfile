FROM php:5-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev libssl-dev libzip-dev nginx procps vim

#RUN pecl install mcrypt-1.0.2 && docker-php-ext-enable mcrypt
RUN docker-php-ext-install -j$(nproc) mcrypt
RUN pecl install mongo && docker-php-ext-enable mongo
RUN pecl install zip && docker-php-ext-enable zip

COPY ./nginx/default.conf /etc/nginx/sites-enabled/default
COPY ./php-fpm/timezone.ini /usr/local/etc/php/conf.d

ADD ./xhgui/ /var/www/xhgui/

WORKDIR /var/www/xhgui

COPY ./config.php /var/www/xhgui/config
COPY ./composer.phar /var/www/xhgui
COPY ./collection_xhgui.patch /var/www/xhgui

RUN php composer.phar install --no-dev
RUN chown -R www-data:www-data /var/www/xhgui
RUN chmod 777 /var/www/xhgui/cache

RUN patch -p1 < collection_xhgui.patch

CMD service nginx start && php-fpm -F

EXPOSE 80
