<?php
$profitColor = ($monthlyRevenue - $monthlyCosts) >= 0 ? '#10b981' : '#ef4444';
?>

<!-- ══ HERO ══════════════════════════════════════════════ -->
<div class="dash-hero">
    <div class="dash-hero-orb-1"></div>
    <div class="dash-hero-orb-2"></div>
    <div class="dash-hero-dots"></div>

    <div class="dash-hero-content">
        <!-- Top row -->
        <div class="flex items-start justify-between gap-6 mb-0">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="pulse-dot green"></div>
                    <span style="color:rgba(165,180,252,0.8); font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase;">Dashboard ejecutivo</span>
                </div>
                <h1 style="font-size:2.4rem; font-weight:900; color:#fff; line-height:1.05; letter-spacing:-0.03em;">Control central</h1>
                <p style="color:rgba(255,255,255,0.4); font-size:0.875rem; margin-top:8px;">
                    <?= date('l, d \d\e F \d\e Y') ?>
                </p>
            </div>
            <div class="flex gap-3 shrink-0 pt-1">
                <a href="/clientes" class="btn-glass text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Nuevo cliente
                </a>
                <a href="/eventos" class="btn-white text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Programar evento
                </a>
            </div>
        </div>

        <!-- KPI strip -->
        <div class="dash-hero-kpi-grid">
            <div class="dash-hero-kpi">
                <p class="dash-hero-kpi-label">Ingresos del mes</p>
                <p class="dash-hero-kpi-value"><?= money($monthlyRevenue) ?></p>
                <p class="dash-hero-kpi-sub">Base contable registrada</p>
            </div>
            <div class="dash-hero-kpi">
                <p class="dash-hero-kpi-label">Utilidad estimada</p>
                <p class="dash-hero-kpi-value" style="color: <?= $profitColor ?>;"><?= money($monthlyRevenue - $monthlyCosts) ?></p>
                <p class="dash-hero-kpi-sub">Ingresos menos egresos</p>
            </div>
            <div class="dash-hero-kpi">
                <p class="dash-hero-kpi-label">Cotizaciones abiertas</p>
                <p class="dash-hero-kpi-value"><?= e($openQuotes) ?></p>
                <p class="dash-hero-kpi-sub">Pipeline <?= money($pipeline) ?></p>
            </div>
            <div class="dash-hero-kpi">
                <p class="dash-hero-kpi-label">Próximos eventos</p>
                <p class="dash-hero-kpi-value"><?= e($upcomingEventsCount) ?></p>
                <p class="dash-hero-kpi-sub"><?= e($closedDeals) ?> tratos cerrados</p>
            </div>
        </div>
    </div>
</div>

<!-- ══ CONTENT GRID ══════════════════════════════════════ -->
<div class="grid gap-6" style="grid-template-columns: 1.5fr 1fr;">

    <!-- Cotizaciones recientes -->
    <div class="card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5" style="border-bottom: 1px solid #f8fafc;">
            <div>
                <h2 class="text-base font-bold text-slate-900">Cotizaciones recientes</h2>
                <p class="text-xs text-slate-400 mt-0.5">Pipeline comercial activo</p>
            </div>
            <a href="/cotizaciones" class="btn-ghost text-xs">Ver todas →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Evento</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach (array_slice($latestQuotes, 0, 7) as $q):
                    $colors = ['avatar-indigo','avatar-violet','avatar-emerald','avatar-amber','avatar-rose','avatar-sky'];
                    $avatarCls = $colors[abs(crc32($q['client_name'])) % count($colors)];
                    $initial = mb_strtoupper(mb_substr($q['client_name'], 0, 1));
                ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar <?= $avatarCls ?>"><?= e($initial) ?></div>
                                <div>
                                    <p class="font-semibold text-slate-900 text-sm"><?= e($q['client_name']) ?></p>
                                    <p class="font-mono text-xs text-slate-400"><?= e($q['code']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="text-slate-600 text-sm max-w-[160px] truncate"><?= e($q['event_name']) ?></td>
                        <td class="font-bold text-slate-900"><?= money($q['total']) ?></td>
                        <td><?= statusBadge($q['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($latestQuotes)): ?>
                    <tr><td colspan="4" class="text-center text-slate-400 py-10 text-sm">Sin cotizaciones recientes</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Agenda próxima -->
    <div class="card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5" style="border-bottom: 1px solid #f8fafc;">
            <div>
                <h2 class="text-base font-bold text-slate-900">Agenda próxima</h2>
                <p class="text-xs text-slate-400 mt-0.5">Próximos <?= count($upcomingEvents) ?> eventos</p>
            </div>
            <a href="/eventos" class="btn-ghost text-xs">Ver agenda →</a>
        </div>

        <?php if (empty($upcomingEvents)): ?>
            <div class="empty-state" style="padding: 48px 32px;">
                <div class="empty-state-icon">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-slate-500 text-sm">Sin eventos próximos</p>
                <a href="/eventos" class="btn-primary text-xs mt-4">Programar evento</a>
            </div>
        <?php else: ?>
            <div class="divide-y divide-slate-50">
            <?php foreach (array_slice($upcomingEvents, 0, 6) as $ev): ?>
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50/60 transition-colors">
                    <div class="date-box shrink-0">
                        <span class="date-box-day"><?= e(date('d', strtotime($ev['event_date']))) ?></span>
                        <span class="date-box-month"><?= e(date('M', strtotime($ev['event_date']))) ?></span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-slate-900 text-sm truncate"><?= e($ev['name']) ?></p>
                        <p class="text-slate-500 text-xs mt-0.5 truncate"><?= e($ev['client_name']) ?></p>
                        <p class="text-slate-400 text-xs"><?= e($ev['city']) ?></p>
                    </div>
                    <?= statusBadge($ev['status']) ?>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ══ QUICK LINKS ════════════════════════════════════════ -->
<div class="grid grid-cols-3 gap-5 mt-6">
    <?php
    $shortcuts = [
        ['/clientes',     '#eef2ff', '#4f46e5', 'Gestionar clientes',    'CRM y cartera de clientes', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['/cotizaciones', '#fffbeb', '#d97706', 'Crear cotización',       'Propuestas y pipeline',     'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['/contabilidad', '#ecfdf5', '#059669', 'Ver contabilidad',       'Ingresos, egresos y flujo', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
    ];
    foreach ($shortcuts as [$href, $bg, $color, $title, $sub, $path]):
    ?>
    <a href="<?= $href ?>" class="card card-lift flex items-center gap-4 px-5 py-4 no-underline group">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 transition-transform group-hover:scale-105"
             style="background: <?= $bg ?>;">
            <svg class="w-5 h-5" fill="none" stroke="<?= $color ?>" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="<?= $path ?>"/>
            </svg>
        </div>
        <div>
            <p class="font-bold text-slate-900 text-sm"><?= $title ?></p>
            <p class="text-slate-400 text-xs mt-0.5"><?= $sub ?></p>
        </div>
        <svg class="w-4 h-4 text-slate-300 ml-auto shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </a>
    <?php endforeach; ?>
</div>
