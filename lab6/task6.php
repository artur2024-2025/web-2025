<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

$raw = null;
$error = null;
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = post_string('n', '');
    $n = validate_factorial_n($raw, $error);
    if ($n !== null) {
        $result = factorial_recursive($n);
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Задание 6 — Факториал (рекурсия)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    html,body{font-family:system-ui,Arial,sans-serif;background:#f6f7fb;margin:0}
    .wrap{max-width:720px;margin:40px auto;background:#fff;border-radius:12px;padding:24px;box-shadow:0 6px 20px rgba(0,0,0,.08)}
    h1{margin:0 0 8px}
    form{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
    input[type=text]{padding:10px 12px;border:1px solid #cfd3d8;border-radius:8px;width:120px;text-align:center}
    button{padding:10px 16px;border:0;border-radius:8px;background:#3740ff;color:#fff;font-size:16px;cursor:pointer}
    .error{margin-top:12px;color:#b00020}
    .ok{margin-top:12px;color:#0a7a29;font-weight:600}
    a{color:#3740ff;text-decoration:none}
    .note{margin-top:6px;color:#546e7a;font-size:14px}
  </style>
</head>
<body>
<div class="wrap">
  <a href="index.php">← к меню</a>
  <h1>Задание 6 — Факториал (рекурсия)</h1>
  <p class="note">Введите целое <b>n</b> от 0 до 20. Используется рекурсивная функция из лекции.</p>

  <form method="post" action="">
    <label for="n">n:</label>
    <input type="text" id="n" name="n" value="<?= h($raw ?? '') ?>">
    <button type="submit">Посчитать</button>
  </form>

  <?php if ($error): ?>
    <div class="error"><?= h($error) ?></div>
  <?php elseif ($result !== null): ?>
    <div class="ok"><?= h((string)$result) ?></div>
  <?php endif; ?>
</div>
</body>
</html>
