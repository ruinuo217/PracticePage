<?php
// db.php (負責資料庫連線)
$server = "127.0.0.1";
$user = "root";
$pw = "";                // XAMPP 預設密碼是空的
$db = "web12_crud";      // 剛剛用 SQL 建立的資料庫名稱

// 建立連線
$conn = mysqli_connect($server, $user, $pw, $db);

// 檢查連線狀態
if (!$conn) {
    die("資料庫連線失敗: " . mysqli_connect_error());
}

// 🌟 極度重要：設定連線編碼，防止中文亂碼
mysqli_set_charset($conn, "utf8mb4");
?>