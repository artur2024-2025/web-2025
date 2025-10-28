<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

/* ----- Инициализация ----- */
$rawYear = null;
$error   = null;
$result  = null;

/* ----- Обработка формы ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $rawYear = post_string('year', '');
  $year    = validate_year($rawYear, $error);

  if ($year !== null) {
    $result = is_leap_year($year) ? 'YES' : 'NO';
  }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Лаба 6 — Задание 1: Високосный год</title>

  <style>
    /* ---------- Базовые стили ---------- */
    html, body {
      font-family: system-ui, Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f6f7fb;
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

    .back {
      margin-bottom: 16px;
      display: inline-block;
      color: #3740ff;
      text-decoration: none;
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
      font-size: 16px;
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

    /* ---------- Вывод сообщений ---------- */
    .error {
      margin-top: 12px;
      color: #b00020;
    }

    .ok {
      margin-top: 12px;
      color: #0a7a29;
      font-weight: 600;
    }

    .note {
      margin-top: 6px;
      color: #546e7a;
      font-size: 14px;
    }

    .card {
      margin-top: 16px;
      padding: 12px 14px;
      background: #f2f5ff;
      border-radius: 10px;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <!-- Ссылка обратно к меню -->
    <a class="back" href="index.php">← к меню лабы</a>

    <h1>Задание 1: Проверка високосного года</h1>
    <p class="note">
      Правило: год високосный, если он делится на 400,
      или делится на 4, но не делится на 100.
    </p>

    <!-- Форма ввода -->
    <form method="post" action="">
      <label for="year">Год:</label>
      <input
        type="text"
        id="year"
        name="year"
        placeholder="например, 2024"
        value="<?= h($rawYear ?? '') ?>"
      >
      <button type="submit">Проверить</button>
    </form>

    <!-- Результат -->
    <?php if ($error): ?>
      <div class="error"><?= h($error) ?></div>
    <?php elseif ($result): ?>
      <div class="card ok"><?= h($result) ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
