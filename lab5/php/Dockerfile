# Используем официальный образ PHP с Apache
FROM php:8.2-apache

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем расширения PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Включаем mod_rewrite для Apache
RUN a2enmod rewrite

# Устанавливаем рабочий каталог
WORKDIR /var/www/html

# Копируем исходный код приложения
# COPY src/ .

# RUN chown -R www-data:www-data .
