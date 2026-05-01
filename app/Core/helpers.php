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

    if ($path === '/') {
        return $current === '/' ? 'active' : '';
    }

    return str_starts_with($current, rtrim($path, '/')) ? 'active' : '';
}

function old(string $key, string $default = ''): string
{
    return e($_POST[$key] ?? $default);
}

function statusBadge(string $status): string
{
    $map = [
        // clients
        'prospecto'    => ['badge-amber',   'Prospecto'],
        'activo'       => ['badge-emerald',  'Activo'],
        'recurrente'   => ['badge-indigo',   'Recurrente'],
        'inactivo'     => ['badge-gray',     'Inactivo'],
        // quotes
        'borrador'     => ['badge-gray',     'Borrador'],
        'enviada'      => ['badge-blue',     'Enviada'],
        'negociacion'  => ['badge-amber',    'Negociación'],
        'aprobada'     => ['badge-emerald',  'Aprobada'],
        'perdida'      => ['badge-red',      'Perdida'],
        // events
        'programado'   => ['badge-blue',     'Programado'],
        'confirmado'   => ['badge-indigo',   'Confirmado'],
        'en_ejecucion' => ['badge-amber',    'En ejecución'],
        'finalizado'   => ['badge-emerald',  'Finalizado'],
        'cancelado'    => ['badge-red',      'Cancelado'],
        // accounting
        'pendiente'    => ['badge-amber',    'Pendiente'],
        'pagado'       => ['badge-emerald',  'Pagado'],
        'parcial'      => ['badge-blue',     'Parcial'],
        'vencido'      => ['badge-red',      'Vencido'],
        // services
        'disponible'   => ['badge-emerald',  'Disponible'],
        'alta_demanda' => ['badge-amber',    'Alta demanda'],
        'mantenimiento'=> ['badge-red',      'Mantenimiento'],
        // accounting type
        'ingreso'      => ['badge-emerald',  'Ingreso'],
        'egreso'       => ['badge-red',      'Egreso'],
    ];
    [$cls, $label] = $map[$status] ?? ['badge-gray', htmlspecialchars($status, ENT_QUOTES, 'UTF-8')];
    return '<span class="badge ' . $cls . '">' . $label . '</span>';
}
