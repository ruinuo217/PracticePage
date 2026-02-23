<?php
// 1. 必須告知瀏覽器這是 JSON 格式
header('Content-Type: application/json; charset=utf-8');
require_once("db.php"); // 確保妳有資料庫連線檔案

$response = [];

// 假設這是處理 POST 請求 (例如留言板或上傳)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '匿名';
    
    // 執行 SQL 寫入 (範例)
    $sql = "INSERT INTO guestbook (name) VALUES ('$user')";
    
    if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
        $response['message'] = '傳送成功！';
    } else {
        $response['success'] = false;
        $response['message'] = '發生錯誤：' . mysqli_error($conn);
    }
}

// 2. 用 JSON 格式輸出並處理中文亂碼
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>