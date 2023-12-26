#!/bin/bash


a2enmod rewrite  # Enable Apache rewrite module
php artisan migrate:fresh --seed  # Run database migrations and seeding

apache2-foreground  # Start Apache server in the foreground
