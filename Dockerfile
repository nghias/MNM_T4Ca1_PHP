# Sử dụng PHP 8.2 kèm Apache
FROM php:8.2-apache

# Cài đặt extension mysqli để kết nối Database
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Cấu hình Apache để chấp nhận file .htaccess (nếu bạn dùng rewrite url)
RUN a2enmod rewrite

# --- QUAN TRỌNG: COPY FILE VÀO SERVER ---

# 1. Copy toàn bộ file trong thư mục 'backend' ra thư mục gốc của web server
COPY backend/ /var/www/html/

# 2. Copy toàn bộ file trong thư mục 'frontend' ra thư mục gốc của web server
# Lưu ý: Lệnh này sẽ để file index.html nằm chung chỗ với file php
COPY frontend/ /var/www/html/

# Phân quyền cho Apache đọc được file
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Mở cổng 80
EXPOSE 80