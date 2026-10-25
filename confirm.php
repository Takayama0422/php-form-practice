<?php
// 安全に画面を表示するため、HTML内に埋め込むためのエスケープ関数を定義
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
    <title>ユーザー登録（2/3）確認</title>
</head>
<body>
    <h2>ユーザー登録（2/3）確認</h2>
    <p>以下の内容で登録します。よろしいですか？</p>

    <table border="1" style="border-collapse: collapse; cellpadding: 5px;">
        <tr>
            <th>お名前</th>
            <td><?= h($name) ?></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><?= h($email) ?></td>
        </tr>
        <tr>
            <th>年齢</th>
            <td><?= h($age) ?>歳</td>
        </tr>
    </table>

    <br>

    <form action="complete.php" method="POST">
        <input type="hidden" name="name" value="<?= h($name) ?>">
        <input type="hidden" name="email" value="<?= h($email) ?>">
        <input type="hidden" name="age" value="<?= h($age) ?>">

        <button type="button" onclick="history.back();">戻る</button>
        <button type="submit">登録する</button>
    </form>
</body>
</html>
