<?php
declare(strict_types=1);

/** Подключение к MySQL через PDO (Laragon: root без пароля) */
function connectDatabase(): PDO
{
    $dsn = 'mysql:host=127.0.0.1;dbname=php_course;charset=utf8mb4';
    $user = 'root';
    $password = ''; // если у root есть пароль — впиши его сюда

    return new PDO($dsn, $user, $password);
}

/** Сохраняем пост и возвращаем его ID (Prepared statements — по лекции) */
function savePostToDatabase(PDO $connection, array $postParams): int
{
    $sql = <<<SQL
        INSERT INTO post (title, subtitle, content)
        VALUES (:title, :subtitle, :content)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->execute([
        ':title'    => $postParams['title'],
        ':subtitle' => $postParams['subtitle'],
        ':content'  => $postParams['content'],
    ]);

    return (int)$connection->lastInsertId();
}

/** Чтение поста по id. Возвращает массив или null (вариант со слайда) */
function findPostInDatabase(PDO $connection, int $id): ?array
{
    $sql = <<<SQL
        SELECT id, title, subtitle, content, posted_at
        FROM post
        WHERE id = $id
    SQL;

    $stmt = $connection->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}
