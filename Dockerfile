# Use an official PHP image as a base
FROM php:8.2-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy composer.lock and composer.json to install dependencies
COPY composer.lock composer.json /var/www/html/

# Install dependencies
RUN apt-get update
RUN apt-get install -y git zip unzip libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader

# Copy all Laravel files to the container
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# Create a temporary file with the new configuration
RUN echo '<VirtualHost *:80>' > /tmp/new_conf.txt \
    && echo '    ServerAdmin webmaster@localhost' >> /tmp/new_conf.txt \
    && echo '    DocumentRoot /var/www/html/public' >> /tmp/new_conf.txt \
    && echo '</VirtualHost>' >> /tmp/new_conf.txt
# Replace the content of 000-default.conf with the content from the temporary file
RUN cat /tmp/new_conf.txt > /etc/apache2/sites-available/000-default.conf
#RUN a2enmod rewrite
#RUN php artisan migrate:fresh --seed
# Expose port 80
EXPOSE 80
ENTRYPOINT ["/var/www/html/shell.sh"]
# Start Apache
#CMD ["apache2-foreground"]
