# backend/Dockerfile
FROM php:8.2-apache

# Cài đặt extension nếu cần (ví dụ mysqli)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy toàn bộ code trong thư mục backend vào server
COPY . /var/www/html/

# Mở port 80 của container (Apache mặc định chạy port 80)
EXPOSE 80