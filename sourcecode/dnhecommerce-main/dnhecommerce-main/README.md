ĐỂ THỰC HIỆN CHẠY DỰ ÁN TRÊN LARAVEL TA THỰC HIỆN CÁC BƯỚC NHƯ SAU:

BƯỚC 1: Tạo tạo database trên phpmyadmin có tên dnhecommerce

BƯỚC 2: Thực hiện chạy các lệnh sau:
    cp .env.example .env
    composer update
    php artisan key:generate

BƯỚC 3: Thực hiện chạy các lệnh sau:
    php artisan config:cache
    php artisan cache:clear

BƯỚC 4: Thực hiện chạy dự án bằng lênh:
    php artisan serve
