                                WEBSITE E-COMMERCE
                                Sàn thương mại điện tử
Ngôn Ngữ: PHP
Framework:Laravel
Database:MYSQL.
-Các USECASE chính:
    Quản lý người dùng.
    Quản lý đặt hàng.
    Quản lý sản phẩm.
    Quản lý giỏ hàng.
    Xem thông tin tài khoản.
    Xem sản phẩm và chi tiết sản phẩm.
    Xem thông tin chi tiết giỏ hàng.
    Đặt hàng.
    Báo cáo thống kê.
-Chức năng
    Cập nhật thông tin tài khoản.
    Thêm, xóa, sửa sản phẩm trong giỏ hàng.
    Thêm, xóa, sửa, xem thông tin người dùng.
    Thêm, xóa, sửa, xem thông tin sản phẩm.
    Cập nhật số lượng sản phẩm trong giỏ hàng.
Chức năng dự kiến phát triển trong tương lai
    Tích hợp chatbot AI.
    Thêm vourcher,...
    Nhập,xuất file excel.
    Thêm các chương trình khuyến mãi.
Cài đặt:
Tải và cài đặt PHP: php.net (yêu cầu phiên bản php 8.3 trở lên)
Tải và cài đặt Visual Studio Code: https://code.visualstudio.com/download
Đầu tiên: Clone dự án github về máy. với câu lệnh,
git clone https://github.com/KhangT05/doanmonhoc
khi đã clone xong, tạo file .env trong cấu trúc thư mục , cùng cấp với folder app.
Copy file .env.example rồi paste vào file .env
Sau khi đã copy xong, gõ lệnh để tạo APP_KEY:
php artisan key:generate
Tiếp tục ta thực hiện liên tiếp các lệnh
composer install, composer update và sau đó npm i
Cuối cùng là chạy
php artisan migrate.
Được rồi , tới đây thì ta chạy ứng dụng thôi. Với câu lệnh
php artisan ser


