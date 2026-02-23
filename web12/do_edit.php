<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: login.php"); exit;
}
require_once("db.php");

// 接收表單傳來的隱藏 ID 與新名字
$id = $_POST['id'];
$new_name = $_POST['mname'];

// 🌟 高分關鍵：安全的 UPDATE 預處理語句，務必加上 WHERE！
$sql = "UPDATE member SET mname = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // 綁定參數 (字串 s, 整數 i)
    mysqli_stmt_bind_param($stmt, "si", $new_name, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // 如果修改的是自己，順便更新 Session 裡的名字
    if ($_SESSION['userID'] == $id) {
        $_SESSION['userName'] = $new_name;
    }
}
mysqli_close($conn);

// 🌟 高分關鍵：導向後立刻 exit
header("Location: list.php");
exit;
?>
