FROM php:8.1.10-fpm

ENV TERM xterm
ENV DEBCONF_NOWARNINGS yes

RUN apt-get update && apt-get install -y \
  build-essential \
  libmcrypt-dev \
  curl \
  libcurl4 \
  libcurl4-openssl-dev \
  zip \
  libzip-dev \
  libmagickwand-dev \
  libxml2-dev \
  libmemcached-dev \
  libz-dev \
  libpq-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libssl-dev \
  git \
  libc-client-dev \
  libkrb5-dev \
  jpegoptim optipng pngquant gifsicle \
  unzip \
  locales

RUN pecl install imagick
RUN pecl install mcrypt-1.0.2

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-enable mcrypt && \
  docker-php-ext-enable imagick && \
  docker-php-ext-configure zip --with-libzip && \
  docker-php-ext-install zip && \
  docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/ && \
  docker-php-ext-install -j$(nproc) gd && \
  docker-php-ext-install curl && \
  docker-php-ext-install -j$(nproc) iconv && \
  docker-php-ext-install dom && \
  docker-php-ext-install json && \
  docker-php-ext-install pdo && \
  docker-php-ext-install mbstring && \
  docker-php-ext-install tokenizer && \
  docker-php-ext-install pdo_mysql && \
  docker-php-ext-install mysqli && \
  docker-php-ext-install bcmath && \
  docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
  docker-php-ext-install imap && \
  docker-php-ext-install exif pcntl


# source bash
RUN . ~/.bashrc

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install wp cli
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

# Add user
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
# COPY . /var/www

# Copy existing application directory permissions
# COPY --chown=www:www . /var/www

# Change current user to www
USER www

WORKDIR /var/www
