<?php
declare(strict_types=1);
/** @var array $post */
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title><?= htmlentities($post['title']) ?></title>
</head>
<body>
  <div class="post-content">
    <h1><?= htmlentities($post['title']) ?></h1>

    <?php if (!empty($post['subtitle'])): ?>
      <h2><?= htmlentities($post['subtitle']) ?></h2>
    <?php endif; ?>

    <p><?= htmlentities($post['content']) ?></p>

    <p><small>Опубликовано: <?= htmlentities($post['posted_at']) ?></small></p>
  </div>

  <p><a href="index.php">← Добавить ещё пост</a></p>
</body>
</html>
