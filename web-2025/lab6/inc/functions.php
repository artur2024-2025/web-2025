<?php
declare(strict_types=1);

/* ===== Общие утилиты ===== */

/** Экранируем вывод в HTML */
function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** POST-параметр как строка (или $default) */
function post_string(string $key, ?string $default = null): ?string {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}

/* ===== Валидации и простая логика ===== */

/** Год: только целые в разумном диапазоне */
function validate_year(?string $raw, ?string &$error): ?int {
    if ($raw === null || $raw === '') { $error = 'Введите год.'; return null; }
    if (!ctype_digit($raw))          { $error = 'Год должен быть целым положительным числом.'; return null; }
    $year = (int)$raw;
    if ($year < 1 || $year > 30000)  { $error = 'Год должен быть в диапазоне 1–30000.'; return null; }
    return $year;
}

/** Високосный год? */
function is_leap_year(int $year): bool {
    return ($year % 400 === 0) || ($year % 4 === 0 && $year % 100 !== 0);
}

/** Цифра 0–9 → слово (ru). Иначе null */
function num_to_word(int $n): ?string {
    $map = [
        0 => 'Ноль', 1 => 'Один', 2 => 'Два', 3 => 'Три', 4 => 'Четыре',
        5 => 'Пять', 6 => 'Шесть', 7 => 'Семь', 8 => 'Восемь', 9 => 'Девять',
    ];
    return $map[$n] ?? null;
}

/** Цифра 0–9 из строки */
function validate_digit(?string $raw, ?string &$error): ?int {
    if ($raw === null || $raw === '')              { $error = 'Введите цифру 0–9.'; return null; }
    if (!ctype_digit($raw) || strlen($raw) !== 1)  { $error = 'Нужна ровно одна цифра 0–9.'; return null; }
    return (int)$raw; // 0..9
}

/** Дата ДД.ММ.ГГГГ → [d,m,y] */
function validate_date_dot(?string $raw, ?string &$error): ?array {
    if ($raw === null || $raw === '') { $error = 'Введите дату в формате ДД.ММ.ГГГГ.'; return null; }
    $raw = trim($raw);

    if (!preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $raw, $m)) {
        $error = 'Неверный формат. Пример: 15.04.1452';
        return null;
    }

    $day = (int)$m[1];
    $mon = (int)$m[2];
    $yr  = (int)$m[3];

    if (!checkdate($mon, $day, $yr)) { $error = 'Некорректная дата.'; return null; }
    return [$day, $mon, $yr];
}

/** Знак зодиака по дню и месяцу */
function zodiac_sign(int $day, int $month): string {
    $md = $month * 100 + $day; // ММДД

    if ($md >= 321  && $md <= 419)  return 'Овен';
    if ($md >= 420  && $md <= 520)  return 'Телец';
    if ($md >= 521  && $md <= 620)  return 'Близнецы';
    if ($md >= 621  && $md <= 722)  return 'Рак';
    if ($md >= 723  && $md <= 822)  return 'Лев';
    if ($md >= 823  && $md <= 922)  return 'Дева';
    if ($md >= 923  && $md <= 1022) return 'Весы';
    if ($md >= 1023 && $md <= 1121) return 'Скорпион';
    if ($md >= 1122 && $md <= 1221) return 'Стрелец';
    if ($md >= 1222 || $md <= 119)  return 'Козерог';
    if ($md >= 120  && $md <= 218)  return 'Водолей';
    return 'Рыбы'; // 219–320
}

/* ===== «Счастливые билеты» (lucky.php) ===== */

/** Сумма первых трёх цифр = сумме последних трёх */
function is_lucky_ticket(int $ticket): bool {
    $digits = str_split(sprintf('%06d', $ticket)); // всегда 6 цифр
    $left  = $digits[0] + $digits[1] + $digits[2];
    $right = $digits[3] + $digits[4] + $digits[5];
    return $left === $right;
}

/** Диапазон билетов A..B (оба по 6 цифр) */
function validate_ticket_range(string $rawA, string $rawB, ?string &$error): ?array {
    if (!preg_match('/^\d{6}$/', $rawA) || !preg_match('/^\d{6}$/', $rawB)) {
        $error = 'Введите ровно 6 цифр для обеих границ.';
        return null;
    }
    $a = (int)$rawA;
    $b = (int)$rawB;
    if ($a > $b) { $error = 'Начало диапазона должно быть меньше или равно концу.'; return null; }
    return [$a, $b];
}

/* ===== Парсинг «гибкой» даты ===== */

/** Русский месяц → номер 1..12 (поддерживает «апр», «апреля», «нояб» и т.п.) */
function month_from_russian(string $s): ?int {
    $s = mb_strtolower($s, 'UTF-8');
    $map = [
        'январ' => 1, 'феврал' => 2, 'март' => 3, 'апрел' => 4,
        'май'   => 5, 'мая'    => 5, 'июн'  => 6, 'июл'  => 7,
        'август'=> 8, 'сентябр'=> 9, 'октябр'=>10, 'ноябр'=>11, 'декабр'=>12,
    ];
    foreach ($map as $root => $n) {
        if (mb_strpos($s, $root) !== false) return $n;
    }
    return null;
}

/**
 * Парсит «любой разумный» формат даты в [d,m,y] без DateTime/strtotime.
 * Примеры: "15.04.1452", "1452-04-15", "15/4/1452", "15 апреля 1452".
 */
function parse_date_flexible(?string $raw, ?string &$error): ?array {
    if ($raw === null || trim($raw) === '') { $error = 'Введите дату.'; return null; }
    $s = trim($raw);

    // 1) ДД.ММ.ГГГГ
    if (preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/u', $s, $m)) {
        $d = (int)$m[1]; $mo = (int)$m[2]; $y = (int)$m[3];
        if (checkdate($mo, $d, $y)) return [$d, $mo, $y];
        $error = 'Некорректная дата.'; return null;
    }

    // 2) ГГГГ-ММ-ДД
    if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/u', $s, $m)) {
        $y = (int)$m[1]; $mo = (int)$m[2]; $d = (int)$m[3];
        if (checkdate($mo, $d, $y)) return [$d, $mo, $y];
        $error = 'Некорректная дата.'; return null;
    }

    // 3) ДД/М/ГГГГ (день/месяц могут быть однозначными)
    if (preg_match('/^(\d{1,2})[\/\s](\d{1,2})[\/\s](\d{4})$/u', $s, $m)) {
        $d = (int)$m[1]; $mo = (int)$m[2]; $y = (int)$m[3];
        if (checkdate($mo, $d, $y)) return [$d, $mo, $y];
        $error = 'Некорректная дата.'; return null;
    }

    // 4) «15 апреля 1452» / «1 янв 2000»
    if (preg_match('/^\s*(\d{1,2})\s+([а-яА-ЯёЁ]+)\s+(\d{4})\s*$/u', $s, $m)) {
        $d = (int)$m[1]; $mo = month_from_russian($m[2]); $y = (int)$m[3];
        if ($mo !== null && checkdate($mo, $d, $y)) return [$d, $mo, $y];
        $error = 'Некорректная дата.'; return null;
    }

    // 5) Фоллбэк: заменяем .-/, на пробелы и пробуем собрать три числа
    $norm  = preg_replace('/[.\-\/,]+/u', ' ', $s);
    $norm  = preg_replace('/\s+/u', ' ', $norm);
    $parts = explode(' ', trim($norm));

    $nums = [];
    foreach ($parts as $p) {
        if (ctype_digit($p)) $nums[] = (int)$p;
    }

    if (count($nums) >= 3) {
        if ($nums[0] > 31) { $y = $nums[0]; $mo = $nums[1]; $d = $nums[2]; } // YYYY M D
        else               { $d = $nums[0]; $mo = $nums[1]; $y = $nums[2]; } // D M YYYY
        if ($mo >= 1 && $mo <= 12 && checkdate($mo, $d, $y)) return [$d, $mo, $y];
    }

    $error = 'Не удалось распознать дату.';
    return null;
}

/* ===== Факториал ===== */

/** n: целое 0..20 */
function validate_factorial_n(?string $raw, ?string &$error): ?int {
    if ($raw === null || $raw === '')  { $error = 'Введите n.'; return null; }
    if (!ctype_digit($raw))            { $error = 'n должно быть целым неотрицательным числом.'; return null; }
    $n = (int)$raw;
    if ($n < 0 || $n > 20)             { $error = 'n должно быть в диапазоне 0–20.'; return null; }
    return $n;
}

/** Факториал (рекурсия). Предполагается, что 0 <= n <= 20 */
function factorial_recursive(int $n): int {
    if ($n === 0 || $n === 1) return 1;
    return $n * factorial_recursive($n - 1);
}

/* ===== ОПЗ (RPN) ===== */

/** Токен — целое (в т.ч. со знаком)? */
function is_int_token(string $t): bool {
    return (bool)preg_match('/^-?\d+$/', $t);
}

/** RPN-выражение: токены через пробелы, разрешены числа и + - * */
function validate_rpn_expr(?string $raw, ?string &$error): ?array {
    if ($raw === null || trim($raw) === '') {
        $error = 'Введите выражение в ОПЗ (токены через пробел).';
        return null;
    }
    $expr   = trim(preg_replace('/\s+/', ' ', $raw));
    $tokens = explode(' ', $expr);

    foreach ($tokens as $t) {
        if (is_int_token($t)) continue;
        if (in_array($t, ['+', '-', '*'], true)) continue;
        $error = "Недопустимый токен: {$t}";
        return null;
    }
    return $tokens;
}

/** Вычисление RPN. Возвращает int или null (пишет $error) */
function eval_rpn(array $tokens, ?string &$error): ?int {
    $stack = [];

    foreach ($tokens as $t) {
        if (is_int_token($t)) { $stack[] = (int)$t; continue; }

        // оператор
        if (count($stack) < 2) { $error = 'Недостаточно операндов.'; return null; }
        $b = array_pop($stack);
        $a = array_pop($stack);

        switch ($t) {
            case '+': $stack[] = $a + $b; break;
            case '-': $stack[] = $a - $b; break;
            case '*': $stack[] = $a * $b; break;
        }
    }

    if (count($stack) !== 1) { $error = 'Ошибка выражения (в стеке остались лишние элементы).'; return null; }
    return (int)$stack[0];
}
