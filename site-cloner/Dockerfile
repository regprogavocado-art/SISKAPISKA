# Site Cloner Service - Интеграция SeoDor siteCloner
FROM php:8.2-apache

# Установка расширений PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    curl \
    json

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка Apache
RUN a2enmod rewrite
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Копирование скриптов SeoDor
WORKDIR /var/www/html
COPY ./seodor-cloner/ .

# Установка прав доступа
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Открытие портов
EXPOSE 80 443

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
  CMD curl -f http://localhost/health.php || exit 1

CMD ["apache2-foreground"]