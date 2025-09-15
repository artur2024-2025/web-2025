<?php
declare(strict_types=1);

// вспомогательная функция
function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// читаем пользователей
$usersJson = @file_get_contents(__DIR__ . '/users.json');
if ($usersJson === false) {
    http_response_code(500);
    exit('Не удалось прочитать users.json');
}

$users = json_decode($usersJson, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    exit('Ошибка JSON: ' . json_last_error_msg());
}

// --- 1. получаем id из GET ---
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if ($id === false || $id === null) {
    // нет id или невалидный → редирект
    header('Location: home.php');
    exit;
}

// --- 2. ищем пользователя ---
$user = null;
foreach ($users as $u) {
    if ((int)$u['id'] === $id) {
        $user = $u;
        break;
    }
}

if (!$user) {
    // пользователь не найден → редирект
    header('Location: home.php');
    exit;
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Lab7 — Profile</title>
  <style>
    body{font-family:system-ui,Arial,sans-serif;max-width:880px;margin:24px auto;padding:0 16px;line-height:1.5}
    .profile{border:1px solid #ddd;border-radius:10px;padding:12px 14px;margin:12px 0}
  </style>
</head>
<body>
  <?php
    // подключаем шаблон профиля
    include __DIR__ . '/profile_template.php';
  ?>
  <p><a href="home.php">← Назад к постам</a></p>
</body>
</html>
