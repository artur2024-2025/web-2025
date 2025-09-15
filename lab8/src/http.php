<?php
declare(strict_types=1);

/** 303 See Other после POST */
function writeRedirectSeeOther(string $location): void
{
    header('HTTP/1.1 303 See Other');
    header("Location: $location");
}
