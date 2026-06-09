<?php
function h(?string $str): string {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// confirm.php から引き継がれたデータを取得
$name  = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録（3/3）完了</title>
</head>
<body>
    <h2>ユーザー登録（3/3）完了</h2>
    
    <p><?= h($name) ?>さん、登録が完了しました！</p>
    <p>確認メールを <?= h($email) ?> に送信しました。</p>

    <br>
    <a href="input.php">最初に戻る</a>
</body>
</html>