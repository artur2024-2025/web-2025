<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

/* ----- Инициализация ----- */
$raw    = null;
$error  = null;
$result = null;

/* ----- Обработка формы ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $raw = post_string('expr', '');

  // допускаем целые (в т.ч. отрицательные) и операции + - *
  $tokens = validate_rpn_expr($raw, $error);
  if ($tokens !== null && $error === null) {
    $result = eval_rpn($tokens, $error); // на выходе должно остаться ровно одно число
  }

  // опционально: чистый текст для автопроверки
  if ($result !== null && !$error && isset($_GET['plain'])) {
    header('Content-Type: text/plain; charset=utf-8');
    echo (string)$result;
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ру">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Задание 7 — Обратная польская запись (RPN)</title>

  <style>
    /* ---------- Общие стили ---------- */
    html, body {
      font-family: system-ui, Arial, sans-serif;
      background: #f6f7fb;
      margin: 0;
    }

    .wrap {
      max-width: 820px;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
    }

    h1 { margin: 0 0 8px; }

    a {
      color: #3740ff;
      text-decoration: none;
    }

    /* ---------- Подсказки ---------- */
    .note {
      margin-top: 6px;
      color: #546e7a;
      font-size: 14px;
    }

    code {
      background: #f4f6ff;
      padding: 2px 6px;
      border-radius: 6px;
    }

    /* ---------- Форма ---------- */
    form {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 12px;
    }

    input[type="text"] {
      width: 420px;
      max-width: 100%;
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
      color: #0a7а29;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <a href="index.php">← к меню</a>

    <h1>Задание 7 — Обратная польская запись</h1>
    <p class="note">
      Токены пишем через пробел. Разрешены целые (в т.ч. отрицательные) и операции
      <code>+</code>, <code>-</code>, <code>*</code>. Пример: <code>8 9 + 1 7 - *</code>
    </p>

    <!-- Форма ввода выражения -->
    <form method="post" action="">
      <label for="expr">Выражение:</label>
      <input
        type="text"
        id="expr"
        name="expr"
        placeholder="например: 8 9 + 1 7 - *"
        value="<?= h($raw ?? '') ?>"
      >
      <button type="submit">Вычислить</button>
    </form>

    <!-- Результат или ошибка -->
    <?php if ($error): ?>
      <div class="error"><?= h($error) ?></div>
    <?php elseif ($result !== null): ?>
      <!-- строго: печатаем одно число -->
      <div class="ok"><?= h((string)$result) ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
