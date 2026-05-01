<?php
declare(strict_types=1);

function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function money(string|int|float|null $value): string
{
    return '$' . number_format((float) $value, 0, ',', '.');
}

function active(string $path): string
{
    $current = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    return rtrim($current, '/') === rtrim($path, '/') ? 'active' : '';
}

function old(string $key, string $default = ''): string
{
    return e($_POST[$key] ?? $default);
}
