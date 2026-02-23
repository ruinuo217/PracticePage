<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>會員登入</title>
</head>
<body>
    <h2>會員登入</h2>
    <form action="do_login.php" method="POST">
        <div>
            <label for="mid">會員帳號：</label>
            <input type="text" id="mid" name="mid" required>
        </div>
        <br>
        <div>
            <label for="mpw">密碼：</label>
            <input type="password" id="mpw" name="mpw" required>
        </div>
        <br>
        <button type="submit">登入</button>
    </form>
</body>
</html>