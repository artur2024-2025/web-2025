<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

$raw = null;
$error = null;
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = post_string('digit', '');
    $n = validate_digit($raw, $error);

    if ($n !== null) {
        $word = num_to_word($n);
        $result = ($word !== null) ? "{$n} → {$word}" : 'Нет соответствия';
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Задание 2 — Цифра → слово</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    html,body{font-family:system-ui,Arial,sans-serif;background:#f6f7fb;margin:0}
    .wrap{max-width:720px;margin:40px auto;background:#fff;border-radius:12px;padding:24px;box-shadow:0 6px 20px rgba(0,0,0,.08)}
    h1{margin:0 0 8px}
    form{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
    input[type=text]{padding:10px 12px;border:1px solid #cfd3d8;border-radius:8px;width:120px;text-align:center;font-size:16px}
    button{padding:10px 16px;border:0;border-radius:8px;background:#3740ff;color:#fff;font-size:16px;cursor:pointer}
    .error{margin-top:12px;color:#b00020}
    .ok{margin-top:12px;color:#0a7a29;font-weight:600}
    .note{margin-top:6px;color:#546e7a;font-size:14px}
    a{color:#3740ff;text-decoration:none}
  </style>
</head>
<body>
<div class="wrap">
  <a href="index.php">← к меню</a>
  <h1>Задание 2 — Цифра → слово</h1>
  <p class="note">Вводите одну цифру от 0 до 9.</p>

  <form method="post" action="">
    <label for="digit">Цифра:</label>
    <input type="text" id="digit" name="digit" maxlength="1" value="<?= h($raw ?? '') ?>">
    <button type="submit">Перевести</button>
  </form>

  <?php if ($error): ?>
    <div class="error"><?= h($error) ?></div>
  <?php elseif ($result): ?>
    <div class="ok"><?= h($result) ?></div>
  <?php endif; ?>
</div>
</body>
</html>
