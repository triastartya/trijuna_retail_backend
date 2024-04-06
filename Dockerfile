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
    pdo_pgsql \
    gd \
    intl \
    zip \
    opcache \
    mbstring
    # Add other PHP extensions here...

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]FROM dunglas/frankenphp
 
RUN install-php-extensions \
    pcntl
    # Add other PHP extensions here...
 
COPY . /app
 
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
