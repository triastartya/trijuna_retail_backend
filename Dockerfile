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
    mbstring \
    pear \
    dev

RUN sudo pecl install mongodb

RUN echo "extension=mongodb.so" | sudo tee -a /etc/php/8.1/cli/php.ini

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]