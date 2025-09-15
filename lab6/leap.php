<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/functions.php';

$rawYear = null;
$error   = null;
$result  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawYear = post_string('year', '');
    $year    = validate_year($rawYear, $error);

    if ($year !== null) {
        $result = is_leap_year($year)
            ? "Год {$year} — високосный ✅"
            : "Год {$year} — невисокосный ❌";
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Лаба 6 — Задание 1: Високосный год</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html,body {font-family: system-ui, Arial, sans-serif; padding: 0; margin: 0; background:#f6f7fb;}
        .wrap {max-width: 720px; margin: 40px auto; background:#fff; border-radius: 12px; padding: 24px; box-shadow: 0 6px 20px rgba(0,0,0,.08);}
        h1 {margin: 0 0 8px;}
        .back {margin-bottom: 16px; display:inline-block; text-decoration:none; color:#3740ff}
        form {display:flex; gap:12px; align-items:center; flex-wrap: wrap;}
        input[type="text"]{padding:10px 12px; border:1px solid #cfd3d8; border-radius:8px; width:180px; font-size:16px;}
        button{padding:10px 16px; border:0; border-radius:8px; background:#3740ff; color:#fff; font-size:16px; cursor:pointer;}
        .error{margin-top:12px; color:#b00020;}
        .ok{margin-top:12px; color:#0a7a29; font-weight:600;}
        .note{margin-top:6px; color:#546e7a; font-size:14px;}
        .card{margin-top:16px; padding:12px 14px; border-radius:10px; background:#f2f5ff;}
        .footer{margin-top:24px; font-size:13px; color:#7a8b99;}
    </style>
</head>
<body>
<div class="wrap">
    <a class="back" href="index.php">← к меню лабы</a>
    <h1>Задание 1: Проверка високосного года</h1>
    <p class="note">Правило: год високосный, если он делится на 400, или делится на 4, но не делится на 100.</p>

    <form method="post" action="">
        <label for="year">Год:</label>
        <input type="text" id="year" name="year" placeholder="например, 2024" value="<?= h($rawYear ?? '') ?>">
        <button type="submit">Проверить</button>
    </form>

    <?php if ($error): ?>
        <div class="error"><?= h($error) ?></div>
    <?php elseif ($result): ?>
        <div class="card ok"><?= h($result) ?></div>
    <?php endif; ?>

    <div class="footer">Исходный код: <code>leap.php</code> + <code>inc/functions.php</code></div>
</div>
</body>
</html>
