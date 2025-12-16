# Sử dụng image PHP chính thức kèm Apache web server
FROM php:8.2-apache

# Cài đặt các extension PHP cần thiết (ví dụ nếu bạn dùng MySQL)
# Nếu api.php không dùng database thì có thể bỏ dòng này
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Bật mod_rewrite của Apache (thường cần cho routing)
RUN a2enmod rewrite

# Copy mã nguồn Frontend vào thư mục gốc của server
COPY ./frontend /var/www/html/

# Copy mã nguồn Backend vào thư mục con /backend
# Lúc này đường dẫn api sẽ là: http://localhost/backend/api.php
COPY ./backend /var/www/html/backend/

# Phân quyền cho thư mục (để Apache có thể đọc/ghi nếu cần)
RUN chown -R www-data:www-data /var/www/html