FROM php:8.1-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Очистка кеша
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка расширений PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создание рабочей директории
WORKDIR /var/www

# Копирование файлов приложения
COPY . /var/www

# Установка зависимостей
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Установка прав
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Открытие порта
EXPOSE 9000

# Запуск PHP-FPM
CMD ["php-fpm"]
