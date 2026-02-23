<?php
session_start();

// 1. 清空所有的 Session 陣列變數
$_SESSION = [];

// 2. 徹底摧毀伺服器上的 Session 檔案
session_destroy();

// 3. 導向回登入頁面
header("Location: login.php");
exit;
?>