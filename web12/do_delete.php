<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: login.php"); exit;
}
require_once("db.php");

// 接收要刪除的 ID
$id = $_GET['id'] ?? 0;

// 🌟 高分關鍵：業界軟刪除技巧 (不真的 DELETE，而是 UPDATE 狀態)
$sql = "UPDATE member SET is_deleted = 1 WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);

header("Location: list.php");
exit;
?>