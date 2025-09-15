<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Добавление поста</title>
</head>
<body>
  <h3>Добавление поста</h3>

  <form action="add_post.php" method="POST">
    <p>Заголовок: <input type="text" name="title" /></p>
    <p>Подзаголовок: <input type="text" name="subtitle" /></p>
    <p>Содержание:</p>
    <p><textarea name="content" rows="8" cols="60"></textarea></p>
    <input type="submit" value="Добавить пост" />
  </form>
</body>
</html>
