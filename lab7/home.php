<?php
declare(strict_types=1);
require_once __DIR__ . '/validation.php';
// --- чтение JSON ---
$usersJson = @file_get_contents(__DIR__ . '/users.json');
$postsJson = @file_get_contents(__DIR__ . '/posts.json');

if ($usersJson === false || $postsJson === false) {
    http_response_code(500);
    exit('Не удалось прочитать файлы JSON.');
}

$users = json_decode($usersJson, true);
$posts = json_decode($postsJson, true);

// проверка ошибок JSON (слайды 46–47)
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    exit('Ошибка JSON: ' . json_last_error_msg());
}

// сделаем быстрый индекс пользователей по id
$usersById = [];
foreach ($users as $u) {
    $usersById[(int)$u['id']] = $u;
}
// Фильтр постов по пользователю: ?user_id=...
$userIdFilter = null;
if (isset($_GET['user_id'])) {
    $userIdFilter = validate_int($_GET['user_id'], 1, null);
    // если такого пользователя нет — сбрасываем фильтр
    if ($userIdFilter !== null && !isset($usersById[$userIdFilter])) {
        $userIdFilter = null;
    }
}

// Если фильтр валиден — оставляем посты только этого пользователя
if ($userIdFilter !== null) {
    $posts = array_values(array_filter($posts, function ($p) use ($userIdFilter) {
        return isset($p['user_id']) && (int)$p['user_id'] === $userIdFilter;
    }));
}

// вспомогательная функция безопасного вывода (слайды 29–32)


?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Lab7 — Home</title>
  <style>
    body{font-family:system-ui,Arial,sans-serif;max-width:880px;margin:24px auto;padding:0 16px;line-height:1.5}
    .post{border:1px solid #ddd;border-radius:10px;padding:12px 14px;margin:12px 0}
    .meta{color:#666;font-size:.9em}
  </style>
</head>
<body>
  <h1>Посты</h1>
  <p>
  Фильтр по пользователю:
  <a href="home.php">Все</a>
  <?php foreach ($users as $u): ?>
    | <a href="home.php?user_id=<?= (int)$u['id'] ?>"><?= h((string)$u['name']) ?></a>
  <?php endforeach; ?>
</p>


  <?php
  // цикл по постам (задание #3 — подключаем шаблон поста)
  foreach ($posts as $post) {
      // автор по user_id (может не найтись)
      $author = $usersById[$post['user_id']] ?? null;

      // делимся переменными с шаблоном:
      // $post (массив поста), $author (массив пользователя или null)
      include __DIR__ . '/post_template.php';
  }
  ?>
</body>
</html>
