<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}else{
    header("Location: dashboard.php");
}
?>