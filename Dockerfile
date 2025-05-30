FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativa o mod_rewrite, caso uses .htaccess
RUN a2enmod rewrite

# Copia código da app para o Apache
COPY ./src /var/www/html/

# Define permissões (opcional)
RUN chown -R www-data:www-data /var/www/html
