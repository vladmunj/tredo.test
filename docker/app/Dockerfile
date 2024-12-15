FROM php:8.2-fpm
 
# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
        libpq-dev \
        git \
        curl \
        zip \
        unzip
 
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
 
# Install extensions for php
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Copy vendor directory
COPY vendor /var/www/tredo/test/vendor

# Copy initial script and set shell mode to it
COPY docker/app/scripts/entrypoint.sh /var/www/tredo/test/docker/scripts/entrypoint.sh
RUN chmod +x /var/www/tredo/test/docker/scripts/entrypoint.sh

# Set working directory
WORKDIR /var/www/tredo/test/

# Create new non root user
USER 1000:1000
 
# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000

# Run initial script
ENTRYPOINT ["./docker/scripts/entrypoint.sh"]

# Run php with config
CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]