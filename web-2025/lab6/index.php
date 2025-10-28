<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Лаба 6 — Меню заданий</title>

  <style>
    /* ---------- Общие стили ---------- */
    html, body {
      font-family: system-ui, Arial, sans-serif;
      background: #f6f7fb;
      margin: 0;
    }

    /* ---------- Контейнер ---------- */
    .wrap {
      max-width: 720px;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    /* ---------- Список ссылок ---------- */
    ul {
      line-height: 1.9;
      padding-left: 20px;
    }

    a {
      color: #3740ff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <h1>Лабораторная 6 — Меню</h1>

    <!-- Список заданий -->
    <ul>
      <li><a href="leap.php">Задание 1: Високосный год</a></li>
      <li><a href="number_to_words.php">Задание 2: Цифра → слово</a></li>
      <li><a href="zodiac.php">Задание 3: Знак зодиака</a></li>
      <li><a href="zodiac_free.php">Задание 4: Знак зодиака (любой формат даты)</a></li>
      <li><a href="lucky.php">Задание 5: Счастливые билеты</a></li>
      <li><a href="task6.php">Задание 6: Факториал (рекурсия)</a></li>
      <li><a href="task7.php">Задание 7: Обратная польская запись</a></li>
      <!-- позже можно добавить оставшиеся задания -->
    </ul>
  </div>
</body>
</html>
