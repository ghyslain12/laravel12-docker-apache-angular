FROM php:8.4-apache

# 1. Configuration Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && a2enmod rewrite

# 2. Installations de base AVEC libicu-dev
RUN apt-get update && apt-get install -y \
    git curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libxml2-dev libonig-dev libcurl4-openssl-dev unzip \
    libicu-dev  # <-- AJOUTÉ ICI

# 3. Extensions PHP (sans intl pour l'instant)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo pdo_mysql zip gd mbstring xml curl bcmath

# 4. Extension intl séparément
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl

# 5. Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 6. Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# 7. Clean
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www