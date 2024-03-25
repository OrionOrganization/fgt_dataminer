FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
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

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets


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

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www

USER orion
