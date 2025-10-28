<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

/* ----- Инициализация ----- */
$raw    = null;
$error  = null;
$result = null;

/* ----- Обработка формы ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $raw = post_string('n', '');
  $n   = validate_factorial_n($raw, $error);

  if ($n !== null) {
    $result = factorial_recursive($n); // вычисляем строго рекурсией
  }

  // опциональный режим "чистого текста" для автопроверки
  if ($result !== null && !$error && isset($_GET['plain'])) {
    header('Content-Type: text/plain; charset=utf-8');
    echo (string)$result; // только число
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Задание 6 — Факториал (рекурсия)</title>

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

    /* ---------- Форма ---------- */
    form {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 12px;
    }

    input[type="text"] {
      width: 120px;
      padding: 10px 12px;
      border: 1px solid #cfd3d8;
      border-radius: 8px;
      text-align: center;
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

    .note {
      margin-top: 6px;
      color: #546e7a;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <a href="index.php">← к меню</a>

    <h1>Задание 6 — Факториал (рекурсия)</h1>
    <p class="note">
      Введите целое <b>n</b> от 0 до 20. Используется рекурсивная функция.
    </p>

    <!-- Форма ввода -->
    <form method="post" action="">
      <label for="n">n:</label>
      <input
        type="text"
        id="n"
        name="n"
        maxlength="2"
        inputmode="numeric"
        pattern="[0-9]{1,2}"
        value="<?= h($raw ?? '') ?>"
      >
      <button type="submit">Посчитать</button>
    </form>

    <!-- Результат или ошибка -->
    <?php if ($error): ?>
      <div class="error"><?= h($error) ?></div>
    <?php elseif ($result !== null): ?>
      <!-- строго: выводим только число -->
      <div class="ok"><?= h((string)$result) ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
