<?php $app = require BASE_PATH . '/config/app.php'; ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Panel') . ' | ' . $app['name']) ?></title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark">E</span>
            <div>
                <strong>Eventia Pro</strong>
                <small>MVC + MySQL</small>
            </div>
        </div>
        <nav class="nav">
            <a class="<?= active('/') ?>" href="/">Dashboard</a>
            <a class="<?= active('/clientes') ?>" href="/clientes">Clientes</a>
            <a class="<?= active('/servicios') ?>" href="/servicios">Servicios</a>
            <a class="<?= active('/cotizaciones') ?>" href="/cotizaciones">Cotizaciones</a>
            <a class="<?= active('/eventos') ?>" href="/eventos">Eventos</a>
            <a class="<?= active('/contabilidad') ?>" href="/contabilidad">Contabilidad</a>
        </nav>
        <div class="sidebar-panel">
            <span>Empresa de eventos</span>
            <strong>Operacion 360</strong>
            <small>Ventas, agenda, inventario y finanzas.</small>
        </div>
    </aside>

    <main class="app-shell">
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="flash"><?= e($_SESSION['flash']) ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php require $viewPath; ?>
    </main>

    <script src="/assets/app.js"></script>
</body>
</html>
