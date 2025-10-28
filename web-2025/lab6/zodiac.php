<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

/* ----- Инициализация ----- */
$raw   = null;
$error = null;
$sign  = null;

/* ----- Обработка формы ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $raw = post_string('date', '');
  $dmY = validate_date_dot($raw, $error);

  if ($dmY !== null) {
    [$d, $m, $y] = $dmY;
    $sign = zodiac_sign($d, $m); // вычисляем знак зодиака
  }

  // режим "чистого текста" для автопроверки
  if ($sign !== null && !$error && isset($_GET['plain'])) {
    header('Content-Type: text/plain; charset=utf-8');
    echo $sign;
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Задание 3 — Знак зодиака (ДД.ММ.ГГГГ)</title>

  <style>
    /* ---------- Общие стили ---------- */
    html, body {
      font-family: system-ui, Arial, sans-serif;
      background: #f6f7fb;
      margin: 0;
    }

    .wrap {
      max-width: 720px;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
    }

    h1 {
      margin: 0 0 8px;
    }

    a {
      color: #3740ff;
      text-decoration: none;
    }

    /* ---------- Подсказка ---------- */
    .note {
      margin-top: 6px;
      color: #546e7a;
      font-size: 14px;
    }

    /* ---------- Форма ---------- */
    form {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 12px;
    }

    input[type="text"] {
      width: 180px;
      padding: 10px 12px;
      border: 1px solid #cfd3d8;
      border-radius: 8px;
    }

    button {
      padding: 10px 16px;
      border: 0;
      border-radius: 8px;
      background: #3740ff;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
    }

    /* ---------- Сообщения ---------- */
    .error {
      margin-top: 12px;
      color: #b00020;
    }

    .ok {
      margin-top: 12px;
      color: #0a7a29;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <a href="index.php">← к меню</a>

    <h1>Задание 3 — Знак зодиака</h1>
    <p class="note">
      Формат ввода: <b>ДД.ММ.ГГГГ</b> (пример: <code>15.04.1452</code>).
    </p>

    <!-- Форма ввода -->
    <form method="post" action="">
      <label for="date">Дата:</label>
      <input
        type="text"
        id="date"
        name="date"
        placeholder="ДД.ММ.ГГГГ"
        value="<?= h($raw ?? '') ?>"
      >
      <button type="submit">Определить</button>
    </form>

    <!-- Ошибка или результат -->
    <?php if ($error): ?>
      <div class="error"><?= h($error) ?></div>
    <?php elseif ($sign !== null): ?>
      <!-- Выводим только знак -->
      <div class="ok"><?= h($sign) ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
