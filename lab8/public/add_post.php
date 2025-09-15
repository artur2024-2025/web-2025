<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/http.php';
require_once __DIR__ . '/../src/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    writeRedirectSeeOther('index.php');
    exit();
}

function handleAddPost(): void
{
    $postData = [
        'title'    => $_POST['title']    ?? '',
        'subtitle' => $_POST['subtitle'] ?? '',
        'content'  => $_POST['content']  ?? '',
    ];

    $connection = connectDatabase();
    $postId = savePostToDatabase($connection, $postData);

    writeRedirectSeeOther("show_post.php?post_id={$postId}");
}

handleAddPost();
