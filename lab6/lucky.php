<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

$rawA = $rawB = null;
$error = null;
$lines = []; // сюда собираем счастливые билеты

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawA = post_string('a', '');
    $rawB = post_string('b', '');

    $range = validate_ticket_range($rawA, $rawB, $error);
    if ($range !== null) {
        [$start, $end] = $range;

        for ($i = $start; $i <= $end; $i++) {
            if (is_lucky_ticket($i)) {
                $lines[] = sprintf("%06d", $i); // печатаем с ведущими нулями
            }
        }
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Счастливые билеты</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    html,body{font-family:system-ui,Arial,sans-serif;background:#f6f7fb;margin:0}
    .wrap{max-width:820px;margin:40px auto;background:#fff;border-radius:12px;padding:24px;box-shadow:0 6px 20px rgba(0,0,0,.08)}
    h1{margin:0 0 8px}
    form{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
    input[type=text]{padding:8px 10px;border:1px solid #cfd3d8;border-radius:8px;width:120px}
    button{padding:8px 14px;border:0;border-radius:8px;background:#3740ff;color:#fff;cursor:pointer}
    .error{margin-top:12px;color:#b00020}
    pre{background:#f4f6ff;padding:12px;border-radius:8px;white-space:pre-wrap}
    a{color:#3740ff;text-decoration:none}
    .note{margin-top:6px;color:#546e7a;font-size:14px}
  </style>
</head>
<body>
<div class="wrap">
  <a href="index.php">← к меню</a>
  <h1>Счастливые билеты</h1>
  <p class="note">Введите границы диапазона <b>в формате ровно 6 цифр</b> (например: <code>000000</code> и <code>000500</code>).</p>

  <form method="post" action="">
    <label for="a">Начало (A):</label>
    <input type="text" id="a" name="a" maxlength="6" value="<?= h($rawA ?? '') ?>">
    <label for="b">Конец (B):</label>
    <input type="text" id="b" name="b" maxlength="6" value="<?= h($rawB ?? '') ?>">
    <button type="submit">Показать</button>
  </form>

  <?php if ($error): ?>
    <div class="error"><?= h($error) ?></div>
  <?php elseif (!empty($lines)): ?>
    <h3>Счастливые билеты:</h3>
    <pre><?php foreach ($lines as $ln) { echo h($ln) . "\n"; } ?></pre>
  <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p>В диапазоне счастливых билетов не найдено.</p>
  <?php endif; ?>
</div>
</body>
</html>
