<?php
// 1. 引入剛剛寫好的連線檔 (這代表你懂檔案抽離)
require_once("db.php");

// 2. 接收表單傳來的資料
$mid = $_POST['mid'];
$mname = $_POST['mname'];
$raw_password = $_POST['mpw'];

// 🌟 高分關鍵 A：現代 PHP 密碼加密處理
// 絕對不存明文密碼，使用 password_hash 進行單向加密
$hashed_pw = password_hash($raw_password, PASSWORD_DEFAULT);

// 🌟 高分關鍵 B：預防 SQL 注入 (Prepared Statements)
// SQL 語句裡的變數一律用問號 ? 取代，結構與資料徹底分離
$sql = "INSERT INTO member (mid, mpw, mname) VALUES (?, ?, ?)";

// 準備語句
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // 綁定參數 ("sss" 代表後面三個變數都是 String 字串型態)
    mysqli_stmt_bind_param($stmt, "sss", $mid, $hashed_pw, $mname);
    
    // 正式執行寫入動作
    if (mysqli_stmt_execute($stmt)) {
        echo "註冊成功！密碼已安全加密。";
        // 實務上這裡通常會用 header('Location: login.php'); 導向登入頁
        // exit; 
    } else {
        echo "註冊失敗，可能是帳號已存在或系統錯誤：" . mysqli_stmt_error($stmt);
    }

    // 關閉 statement 資源
    mysqli_stmt_close($stmt);
} else {
    echo "SQL 語法準備失敗！";
}

// 關閉資料庫連線
mysqli_close($conn);
?>