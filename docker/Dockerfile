FROM php:8.2-fpm-alpine

# Add Repositories
RUN rm -f /etc/apk/repositories && \
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.18/main" >> /etc/apk/repositories && \
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.18/community" >> /etc/apk/repositories

# fix work iconv library with alpine
RUN apk add --no-cache gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

# Add Build Dependencies
RUN apk update && apk add --no-cache  \
    libzip-dev \
    libmcrypt-dev \
    libjpeg-turbo-dev \
    libjpeg-turbo \
    jpeg-dev \
    libpng-dev \
    libxml2-dev \
    bzip2-dev \
    libwebp-dev \
    zip \
    jpegoptim \
    pngquant \
    optipng \
    icu-dev \
    freetype-dev \
    zlib-dev \
    curl-dev \
    imap-dev \
    git \
    vim \
    autoconf \
    g++ \
    make

# Configure and install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install -j "$(nproc)" gd

# Configure & Install other extensions
RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-configure zip && \
    docker-php-ext-configure imap && \
    docker-php-ext-install -j "$(nproc)" \
    opcache \
    pdo \
    pdo_mysql \
    zip \
    imap

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Add Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

COPY docker/opcache.ini $PHP_INI_DIR/conf.d/
COPY docker/php.ini $PHP_INI_DIR/conf.d/

# Setup Working Dir
WORKDIR /var/www/app

COPY docker/init.sh /usr/local/bin
RUN chmod +x /usr/local/bin/init.sh
CMD ["php-fpm"]
ENTRYPOINT ["/usr/local/bin/init.sh"]
