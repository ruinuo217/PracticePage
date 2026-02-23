<?php
// 🌟 高分關鍵 1：啟動 Session，並檢查使用者到底有沒有登入
session_start();

// 如果沒有登入的紀錄，就強制把他踢回登入頁面，保護這個後台！
if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] !== true) {
    header("Location: login.php");
    exit;
}

// 引入連線檔
require_once("db.php");

// 準備一個空陣列來存放所有會員資料
$members = [];

// 🌟 高分關鍵 2：只撈取「未被軟刪除」的會員 (is_deleted = 0)
$sql = "SELECT id, mid, mname FROM member WHERE is_deleted = 0";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    // 🌟 高分關鍵 3：現代寫法，直接一次把所有資料抓出來變成多維陣列！
    $members = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// 關閉資料庫連線
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>會員列表管理</title>
    <style>
        /* 簡單的表格美化，讓你的作業看起來更專業 */
        table { border-collapse: collapse; width: 60%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f0db4f; color: #333; }
        .action-links a { margin-right: 10px; text-decoration: none; color: blue; }
        .action-links a.delete { color: red; }
    </style>
</head>
<body>
    <h2>歡迎，<?= htmlspecialchars($_SESSION['userName'], ENT_QUOTES); ?>！這是會員清單</h2>
    
    <a href="logout.php">登出系統</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>會員帳號</th>
                <th>顯示名稱</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($members)): ?>
                <tr><td colspan="4">目前沒有會員資料。</td></tr>
            <?php else: ?>
                <?php foreach ($members as $user): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= htmlspecialchars($user['mid'], ENT_QUOTES); ?></td>
                        <td><?= htmlspecialchars($user['mname'], ENT_QUOTES); ?></td>
                        <td class="action-links">
                            <a href="edit.php?id=<?= $user['id']; ?>">編輯</a>
                            <a href="#" class="delete" onclick="deleteMember(<?= $user['id']; ?>)">刪除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        // 🌟 預先準備 Step 6 的前端防呆確認
        function deleteMember(id) {
            if (confirm('你確定要刪除這筆會員資料嗎？')) {
                window.location.href = 'do_delete.php?id=' + id;
            }
        }
    </script>
</body>
</html>