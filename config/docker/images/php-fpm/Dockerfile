FROM php:7.1-fpm

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update \
    && apt-get install -y zlib1g-dev libicu-dev g++ libcurl4-openssl-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev libxml2-dev \
    && apt-get install -y git less subversion unzip wget mysql-client stow \
    && apt-get install -y libxrender1 libfontconfig \
    && apt-get install -y libc6

RUN docker-php-ext-configure bcmath && docker-php-ext-install bcmath \
    && docker-php-ext-configure curl && docker-php-ext-install curl \
    && docker-php-ext-configure exif && docker-php-ext-install exif \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install gd \
    && docker-php-ext-configure intl && docker-php-ext-install intl \
    && docker-php-ext-configure mbstring && docker-php-ext-install mbstring \
    && docker-php-ext-configure mcrypt && docker-php-ext-install mcrypt \
    && docker-php-ext-configure pdo && docker-php-ext-install pdo \
    && docker-php-ext-configure pdo_mysql && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure soap && docker-php-ext-install soap \
    && docker-php-ext-configure zip && docker-php-ext-install zip

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN echo "date.timezone = Europe/Paris" >> /usr/local/etc/php/php.ini \
    && echo "short_open_tag = Off" >> /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer && php installer \
    && mv composer.phar /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer \
    && rm installer

# Install Chrome
RUN apt-get install -y fonts-liberation
RUN wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
RUN dpkg -i google-chrome-stable_current_amd64.deb; apt-get -fy install


ENV COMPOSER_HOME /composer
RUN composer global require hirak/prestissimo

COPY mysql.ini /usr/local/etc/php/conf.d/mysql.ini

ENV HOME /home/novaway
WORKDIR $HOME
RUN chmod a+rwx $HOME

ENV GOSU_VERSION 1.10
RUN arch="$(dpkg --print-architecture | awk -F- '{ print $NF }')" \
    && wget -O gosu "https://github.com/tianon/gosu/releases/download/1.10/gosu-$arch" \
    && mv ./gosu /usr/local/bin/gosu \
    && chmod +x /usr/local/bin/gosu

RUN sed -i 's/\/proc\/self\/fd\/2/\/home\/novaway\/php.log/g' /usr/local/etc/php-fpm.d/docker.conf

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod a+x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["php-fpm"]
