# Resmi PHP-FPM imajını kullanarak başlayın
FROM php:8.1.18-cli-bullseye

# Gerekli paketleri yükleyin
RUN apt-get update && \
    apt-get install -y \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        git

# PHP eklentilerini yükleyin
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer'ı yükleyin
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Uygulama dizininin içine gidin ve kaynak dosyalarını kopyalayın
WORKDIR /var/www/html
COPY . .

# Composer bağımlılıklarını yükleyin
RUN composer install --no-scripts --no-autoloader

# Composer autoloader'ını yükleyin
RUN composer dump-autoload --optimize

# Uygulama dizinindeki dosyaların sahibi olarak www-data'yı ayarlayın
RUN chown -R www-data:www-data /var/www/html

# Erişim izinlerini ayarlayın
RUN chmod -R 755 storage
RUN chmod -R 755 bootstrap/cache
RUN composer update
RUN php artisan migrate
RUN php artisan cache:clear
RUN php artisan serve

# Uygulamayı çalıştırın
CMD ["php-fpm"]
