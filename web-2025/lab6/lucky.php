<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

/* ----- Инициализация ----- */
$rawA  = null;
$rawB  = null;
$error = null;
$text  = null; // сюда соберём счастливые номера: по одному на строку

/* ----- Обработка формы ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $rawA = post_string('a', '');
  $rawB = post_string('b', '');

  $range = validate_ticket_range($rawA ?? '', $rawB ?? '', $error);
  if ($range !== null) {
    [$start, $end] = $range;

    $lines = [];
    for ($i = $start; $i <= $end; $i++) {
      if (is_lucky_ticket($i)) {
        $lines[] = sprintf('%06d', $i); // фиксируем ширину: ровно 6 цифр
      }
    }
    $text = implode("\n", $lines); // строго построчный вывод
  }

  // опционально: «чистый» текст для автопроверки
  if ($error === null && $text !== null && isset($_GET['plain'])) {
    header('Content-Type: text/plain; charset=utf-8');
    echo $text; // может быть пустой строкой — значит, ничего не нашли
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Лаба 6 — Задание 5: Счастливые билеты</title>

  <style>
    /* ---------- Базовые стили ---------- */
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

    /* ---------- Форма ---------- */
    form {
      display: flex;
      gap: 12px;
      align-items: center;
      flex-wrap: wrap;
    }

    input[type="text"] {
      width: 120px;
      padding: 8px 10px;
      border: 1px solid #cfd3d8;
      border-radius: 8px;
      text-align: center;
    }

    button {
      padding: 8px 14px;
      border: 0;
      border-radius: 8px;
      background: #3740ff;
      color: #fff;
      cursor: pointer;
    }

    /* ---------- Сообщения/результат ---------- */
    .note {
      margin-top: 6px;
      color: #546e7a;
      font-size: 14px;
    }

    .error {
      margin-top: 12px;
      color: #b00020;
    }

    pre {
      background: #f7f7f9;
      padding: 12px;
      border-radius: 8px;
      white-space: pre-wrap;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <a href="index.php">← к меню</a>

    <h1>Задание 5 — Счастливые билеты</h1>
    <p class="note">
      Введите границы диапазона в формате ровно 6 цифр
      (например: <code>000000</code> и <code>000500</code>).
    </p>

    <!-- Форма ввода диапазона -->
    <form method="post" action="">
      <label for="a">Начало (A):</label>
      <input type="text" id="a" name="a" maxlength="6" value="<?= h($rawA ?? '') ?>">

      <label for="b">Конец (B):</label>
      <input type="text" id="b" name="b" maxlength="6" value="<?= h($rawB ?? '') ?>">

      <button type="submit">Показать</button>
    </form>

    <!-- Выводим ошибку или результат -->
    <?php if ($error): ?>
      <div class="error"><?= h($error) ?></div>
    <?php elseif ($text !== null): ?>
      <?php if ($text !== ''): ?>
        <h3>Счастливые билеты:</h3>
        <!-- В результате — только номера построчно -->
        <pre><?= h($text) ?></pre>
      <?php else: ?>
        <p>В диапазоне счастливых билетов не найдено.</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</body>
</html>
