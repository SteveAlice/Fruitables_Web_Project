<?php

class constGuards{ //Lớp này định nghĩa các hằng số để xác định các loại người dùng trong hệ thống
    const ADMIN ='admin';
    const CLIENT ='client';
    const SELLER ='seller';
}
class constDefaults{  // xác định thời hạn của mã thông báo (token) khi cài đặt tính năng quên mật khẩu.
    const tokenExpiredMinutes = 15;  //mã thông báo quên mật khẩu sẽ hết hạn sau 15 phút.
}
