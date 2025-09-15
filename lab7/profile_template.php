<?php
// Ожидается массив $user
$name  = isset($user['name']) ? h((string)$user['name']) : '';
$email = isset($user['email']) ? h((string)$user['email']) : '';
$regTs = isset($user['registered']) ? (int)$user['registered'] : 0;
$regHuman = $regTs > 0 ? date('Y-m-d H:i', $regTs) : '—';
?>
<div class="profile">
  <h2>Профиль пользователя</h2>
  <p><strong>Имя:</strong> <?= $name ?></p>
  <p><strong>Email:</strong> <?= $email ?></p>
  <p><strong>Дата регистрации:</strong> <?= h($regHuman) ?></p>
</div>
