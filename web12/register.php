<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>會員註冊</title>
</head>
<body>
    <h2>註冊新會員</h2>
    <form action="do_register.php" method="POST">
        <div>
            <label for="mid">會員帳號：</label>
            <input type="text" id="mid" name="mid" required>
        </div>
        <br>
        <div>
            <label for="mname">顯示名稱：</label>
            <input type="text" id="mname" name="mname" required>
        </div>
        <br>
        <div>
            <label for="mpw">設定密碼：</label>
            <input type="password" id="mpw" name="mpw" required>
        </div>
        <br>
        <button type="submit">確認註冊</button>
    </form>
</body>
</html>