FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg-dev \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        git \
        zip \
        curl \
        unzip \
        nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install lumen dependencies
RUN docker-php-ext-install bcmath pdo_mysql mysqli zip exif pcntl
RUN docker-php-ext-configure gd --enable-gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create working directory
WORKDIR /var/www/html

# Add PHP main config file
COPY ./conf.d/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Copy the source code into the container
# COPY . /var/www/html

# Set nedded permisions
# RUN chmod -R 777 storage

# Expose port 9000 and start php-fpm server
EXPOSE 9000

# start php-fpm
CMD composer install; php-fpm
