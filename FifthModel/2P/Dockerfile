# Dockerfile для развертывания PHP приложения
FROM php:8.2-fpm-alpine

# Устанавливаем системные зависимости
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Устанавливаем PHP расширения
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем файлы composer для установки зависимостей
COPY composer.json composer.lock ./

# Установка зависимостей
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-autoloader

# Копируем остальные файлы приложения
COPY . .

# Завершаем настройку autoloader
RUN composer dump-autoload --optimize

# Настраиваем права доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Копируем конфигурацию nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Открываем порт
EXPOSE 80

# Запускаем supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]