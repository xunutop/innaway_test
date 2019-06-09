Innaway test 

Prerequisites

Sử dụng môi trường phát triển laravel hoặc  [laradoc](https://laradock.io).

Installing

Tạo file môi trường.
```bash
    # di chuyển tới thư mục chưa source code
    cd innaway_test
    cp .env.example .env
```

Thay đổi thông tin kết lối CSDL trong file .env theo môi trường thử nghiệm. vd:
```
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=default
    DB_USERNAME=default
    DB_PASSWORD=secret
```

Tắt strict mode trong mysql. 
```bash
    # di chuyển tới thư mục chưa source code
    cd innaway_test
    # sửa file cấu hình csdl
    vim app/config/database.php
```
sửa cấu hình tại  `['connections']['mysql']['strict']` thành giá trị **false**

Khởi tạo CSDL.
```bash
    # di chuyển tới thư mục chưa source code
    cd innaway_test
    # chạy lệnh migrate 
    php artisan migrate
```
Nếu vào CSDL thấy 2 bẳng `transactions` và `sell_logs` là thành công.

