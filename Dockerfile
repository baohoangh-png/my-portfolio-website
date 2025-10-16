# ==========================
# 🧱 Giai đoạn 0: Node.js Builder - Build frontend
# ==========================
FROM node:18-alpine AS nodejs_builder

WORKDIR /app

# ✅ Sao chép package.json, và chỉ sao chép package-lock.json nếu có
# Dòng dưới dùng để tránh lỗi nếu file package-lock.json không tồn tại
COPY package.json ./
# COPY package-lock.json ./  # ❌ bỏ qua nếu bạn không có file này

# Cài đặt dependencies
RUN npm install

# Sao chép toàn bộ mã nguồn
COPY . .

# Build frontend (đảm bảo bạn có script "build" trong package.json)
RUN npm run build


# ==========================
# 🐘 Giai đoạn 1: PHP Builder - Cài đặt Laravel và PHP
# ==========================
FROM php:8.2-fpm-alpine AS php_builder

# Cài đặt các thư viện hệ thống cần thiết
RUN apk add --no-cache \
    git \
    nginx \
    postgresql-dev \
    libpq \
    sqlite-dev \
    libzip-dev \
    imagemagick-dev \
    libwebp-dev \
    supervisor \
    bash

# Cài đặt PHP extensions phổ biến
RUN docker-php-ext-install -j$(nproc) pdo_mysql pdo_pgsql zip

WORKDIR /app

# ✅ Sao chép Composer file (composer.json + composer.lock nếu có)
COPY composer.json ./
# COPY composer.lock ./  # ❌ Bỏ nếu bạn chưa có composer.lock

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.7.2

# Cài đặt dependencies của PHP (production mode)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Sao chép toàn bộ mã nguồn Laravel
COPY . .

# ✅ Sao chép các file đã build từ giai đoạn Node.js
COPY --from=nodejs_builder /app/public/build /app/public/build

# Cấp quyền cho storage và bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Tạo .env nếu chưa có
RUN cp .env.example .env || true

# Cache cấu hình Laravel
RUN php artisan key:generate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan event:cache


# ==========================
# 🚀 Giai đoạn 2: Production Image
# ==========================
FROM php:8.2-fpm-alpine

# Cài đặt Nginx và Supervisor
RUN apk add --no-cache nginx supervisor

WORKDIR /var/www/html

# Sao chép ứng dụng đã build
COPY --from=php_builder /app /var/www/html

# Sao chép cấu hình Nginx và Supervisor
COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY supervisord.conf /etc/supervisord.conf

# Cấp quyền cho các thư mục cần thiết
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Expose port 8000
EXPOSE 8000

# Chạy Supervisor để quản lý Nginx & PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
