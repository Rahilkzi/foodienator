FROM php:7.4-apache

# Install required extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite (important for CodeIgniter routes)
RUN a2enmod rewrite

# Copy project files into container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Set permissions (important for CI cache/logs/uploads)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Set Apache document root to /var/www/html/public (CI public folder)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/

