<?php
// 🌟 高分關鍵 1：Session 起手式，絕對要寫在第一行！
session_start();

// 引入連線檔
require_once("db.php");

$mid = $_POST['mid'];
$raw_password = $_POST['mpw'];

// 1. 使用預處理語句尋找這個帳號
// 注意：我們順便加上 is_deleted = 0 的條件，確保被軟刪除的帳號不能登入
$sql = "SELECT id, mid, mpw, mname FROM member WHERE mid = ? AND is_deleted = 0";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // 綁定參數 (一個字串 "s")
    mysqli_stmt_bind_param($stmt, "s", $mid);
    mysqli_stmt_execute($stmt);
    
    // 取得查詢結果
    $result = mysqli_stmt_get_result($stmt);

    // 2. 檢查有沒有找到這個帳號
    if ($row = mysqli_fetch_assoc($result)) {
        
        // 🌟 高分關鍵 2：現代 PHP 密碼驗證
        // 使用 password_verify() 讓 PHP 自己去比對「明文密碼」跟資料庫裡的「亂碼」是否吻合
        if (password_verify($raw_password, $row['mpw'])) {
            
            // 🌟 高分關鍵 3：資安防禦 (Session Fixation)
            // 登入成功時，強制換發一把新的 Session 鑰匙！
            session_regenerate_id(true);

            // 把使用者的登入狀態與資訊寫入 Session 記起來
            $_SESSION['isLogin'] = true;
            $_SESSION['userID'] = $row['id'];
            $_SESSION['userName'] = $row['mname'];

            // 🛡️ 輸出資料時務必使用 htmlspecialchars 防護 XSS
            $safeName = htmlspecialchars($row['mname'], ENT_QUOTES);
            echo "登入成功！歡迎回來，{$safeName}！";
            
            // 實務上這裡會用 header('Location: list.php'); 導向會員列表頁
            // exit;
            
        } else {
            echo "登入失敗：密碼錯誤！";
        }
    } else {
        echo "登入失敗：找不到此帳號，或帳號已被刪除。";
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo "系統錯誤：SQL 語法準備失敗";
}

mysqli_close($conn);
?>