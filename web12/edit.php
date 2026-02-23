<?php
session_start();
// 檢查登入狀態
if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once("db.php");

// 取得網址上的 ID (如果沒有就預設為 0)
$target_id = $_GET['id'] ?? 0;

// 使用預處理語法抓取這筆會員資料
$sql = "SELECT id, mid, mname FROM member WHERE id = ? AND is_deleted = 0";
$stmt = mysqli_prepare($conn, $sql);

$memberData = null;
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $target_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // 抓取單筆資料
    $memberData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);

// 如果找不到資料，踢回列表頁
if (!$memberData) {
    die("找不到該會員資料！<a href='list.php'>回列表</a>");
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>編輯會員資料</title>
</head>
<body>
    <h2>編輯會員資料</h2>
    <form action="do_edit.php" method="POST">
        <input type="hidden" name="id" value="<?= $memberData['id']; ?>">
        
        <div>
            <label>會員帳號：</label>
            <input type="text" value="<?= htmlspecialchars($memberData['mid']); ?>" readonly style="background-color: #eee;">
        </div>
        <br>
        <div>
            <label for="mname">顯示名稱：</label>
            <input type="text" id="mname" name="mname" value="<?= htmlspecialchars($memberData['mname']); ?>" required>
        </div>
        <br>
        <button type="submit">儲存修改</button>
        <a href="list.php">取消返回</a>
    </form>
</body>
</html>