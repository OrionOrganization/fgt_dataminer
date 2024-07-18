FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev\
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libxpm-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip


# Install PHP extensions
RUN docker-php-ext-configure gd --with-webp --with-jpeg

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install pgsql pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u 1000 -d /home/orion orion
RUN mkdir -p /home/orion/.composer && \
    chown -R orion:orion /home/orion

# Install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

#dockerfile
RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www

USER orion
