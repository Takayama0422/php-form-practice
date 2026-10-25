<?php
function h(?string $str): string {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

require_once __DIR__.'/input-validation.php';
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST'); http_response_code(405); exit('Method not allowed.');
}
try { $input = validatedFormInput($_POST); }
catch (InvalidArgumentException) { http_response_code(400); exit('Invalid form input.'); }
$name = $input['name']; $email = $input['email']; $age = $input['age'];
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
