<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録（1/3）入力</title>
</head>
<body>
    <h2>ユーザー登録（1/3）入力</h2>

    <form action="confirm.php" method="POST">
        <p>
            <label>お名前：<br>
                <input type="text" name="name" maxlength="100" required>
            </label>
        </p>
        <p>
            <label>メールアドレス：<br>
                <input type="email" name="email" maxlength="254" required>
            </label>
        </p>
        <p>
            <label>年齢：<br>
                <input type="number" name="age" min="0" max="150" required>
            </label>
        </p>
        <button type="submit">確認画面へ</button>
    </form>
</body>
</html>
