FROM dunglas/frankenphp

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN install-php-extensions \
    pcntl \
    pdo_pgsql \
    gd \
    intl \
    zip \
    opcache \
    mbstring

RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set PHP configurations for file uploads
RUN echo "upload_max_filesize=500M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=500M" >> /usr/local/etc/php/conf.d/uploads.ini
    && echo "max_execution_time=0" >> /usr/local/etc/php/conf.d/uploads.ini
RUN php -m | grep mongodb

# RUN pecl install mongodb

# RUN echo "extension=mongodb.so" | tee -a /etc/php/8.1/cli/php.ini

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]