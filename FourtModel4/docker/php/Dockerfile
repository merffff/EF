FROM php:8.2-fpm

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    supervisor

# Установка PHP расширений
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip sockets

# Установка Redis расширения
RUN pecl install redis && docker-php-ext-enable redis

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создание пользователя
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Установка прав
RUN chown -R www:www /var/www

# Переключение на пользователя www
USER www

# Рабочая директория
WORKDIR /var/www

# Открытие порта
EXPOSE 9000

CMD ["php-fpm"]