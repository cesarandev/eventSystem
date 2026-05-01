<?php
$app = require BASE_PATH . '/config/app.php';
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$navItem = function(string $href, string $label, string $icon) use ($currentPath): string {
    $active = $href === '/'
        ? $currentPath === '/'
        : str_starts_with($currentPath, rtrim($href, '/'));
    $cls = $active
        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25'
        : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100';
    return "<a href=\"{$href}\" class=\"flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-150 {$cls}\">{$icon}{$label}</a>";
};

$icons = [
    'dashboard'    => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-3a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/></svg>',
    'clientes'     => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
    'servicios'    => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
    'cotizaciones' => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
    'eventos'      => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
    'contabilidad' => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
];
?>
<!doctype html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Panel') . ' — ' . $app['name']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#eef2ff', 100:'#e0e7ff', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca', 900:'#1e1b4b' }
                    },
                    fontFamily: { sans: ['Inter','system-ui','-apple-system','sans-serif'] }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body class="h-full bg-slate-50 text-slate-900 font-sans antialiased">

<div class="flex min-h-screen">

    <!-- ── Sidebar ─────────────────────────────────────── -->
    <aside class="fixed inset-y-0 left-0 w-72 bg-slate-900 flex flex-col z-40 overflow-y-auto">

        <!-- Brand -->
        <div class="flex items-center gap-3 px-6 py-6 border-b border-slate-800">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shrink-0 shadow-lg shadow-indigo-500/30">E</div>
            <div>
                <p class="text-white font-bold text-sm leading-tight">Eventia Pro</p>
                <p class="text-slate-500 text-xs">Plataforma de eventos</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-4 py-5 space-y-1">
            <p class="text-slate-600 text-xs font-semibold uppercase tracking-widest px-4 mb-3">Menú principal</p>
            <?= $navItem('/', 'Dashboard', $icons['dashboard']) ?>
            <?= $navItem('/clientes', 'Clientes', $icons['clientes']) ?>
            <?= $navItem('/servicios', 'Servicios', $icons['servicios']) ?>
            <?= $navItem('/cotizaciones', 'Cotizaciones', $icons['cotizaciones']) ?>
            <?= $navItem('/eventos', 'Eventos', $icons['eventos']) ?>
            <?= $navItem('/contabilidad', 'Contabilidad', $icons['contabilidad']) ?>
        </nav>

        <!-- Workspace info -->
        <div class="px-6 py-5 border-t border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-slate-700 flex items-center justify-center text-slate-300 text-sm font-bold shrink-0">O</div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-semibold truncate">Operación 360</p>
                    <p class="text-slate-500 text-xs truncate">Ventas · Agenda · Finanzas</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- ── Main content ─────────────────────────────────── -->
    <div class="ml-72 flex-1 flex flex-col min-w-0">

        <!-- Flash -->
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="mx-8 mt-6 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-semibold shadow-sm">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?= e($_SESSION['flash']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <main class="flex-1 px-8 py-8">
            <?php require $viewPath; ?>
        </main>

        <footer class="px-8 py-4 border-t border-slate-100 text-xs text-slate-400">
            Eventia Pro &mdash; <?= date('Y') ?>
        </footer>
    </div>
</div>

<script src="/assets/app.js"></script>
</body>
</html>
