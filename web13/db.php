<?php
$host = 'localhost';
$user = 'root';        // XAMPP 預設帳號
$password = '';        // XAMPP 預設密碼是空的
$database = 'web12_crud';  // 👈 這裡請確認妳的資料庫名稱

// 建立連線
$conn = mysqli_connect($host, $user, $password, $database);

// 檢查連線是否成功
if (!$conn) {
    die("資料庫連線失敗：" . mysqli_connect_error());
}

// 設定連線編碼為 utf8，避免中文亂碼
mysqli_set_charset($conn, "utf8");
?>