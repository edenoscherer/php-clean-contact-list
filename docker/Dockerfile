FROM php:8.1.7-apache

# Apache config
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/xdebug-local.ini /usr/local/etc/php/conf.d/xdebug-local.ini

# Install unzip utility and libs needed by zip PHP extension
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libjpeg62-turbo-dev


RUN pecl install xdebug-3.1.5
# RUN docker-php-ext-enable xdebug
RUN echo "xdebug.mode=coverage,debug" >> /usr/local/etc/php/php.ini

# Install GD2
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# Install Postgre PDO
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip


#setup composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

COPY ./composer.json ./
COPY ./composer.lock ./

RUN composer install

# Copy application source
COPY . /var/www/html/

RUN mkdir -p /var/www/html/cache
RUN mkdir -p /var/www/html/logs
RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite
RUN service apache2 restart;

# RUN /var/www/html/vendor/bin/phinx migrate
