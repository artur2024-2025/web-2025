<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/database.php';

$postId = (int)($_GET['post_id'] ?? 0);
if (!$postId) {
    http_response_code(400);
    echo 'Некорректный параметр post_id';
    exit;
}

$connection = connectDatabase();
$post = findPostInDatabase($connection, $postId);

if (!$post) {
    http_response_code(404);
    echo 'Пост не найден';
    exit;
}

// Рендер в отдельном файле-шаблоне (как в лекции)
require __DIR__ . '/../src/view/post.php';
