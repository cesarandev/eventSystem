<!-- ── Page header ──────────────────────────────────────── -->
<div class="flex items-start justify-between gap-6 mb-8">
    <div>
        <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-1">Dashboard ejecutivo</p>
        <h1 class="text-3xl font-bold text-slate-900 leading-tight">Control central</h1>
        <p class="text-slate-500 text-sm mt-1">Empresa de recreación y eventos &mdash; <?= date('d \d\e F, Y') ?></p>
    </div>
    <div class="flex gap-3 pt-1 shrink-0">
        <a href="/clientes" class="btn-secondary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo cliente
        </a>
        <a href="/eventos" class="btn-primary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Programar evento
        </a>
    </div>
</div>

<!-- ── KPI metrics ──────────────────────────────────────── -->
<div class="grid grid-cols-4 gap-5 mb-8">

    <div class="metric-card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Ingresos del mes</span>
            <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-900 metric-value"><?= money($monthlyRevenue) ?></p>
        <p class="text-xs text-slate-400 mt-1">Base contable en MySQL</p>
    </div>

    <div class="metric-card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Utilidad estimada</span>
            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-900 metric-value"><?= money($monthlyRevenue - $monthlyCosts) ?></p>
        <p class="text-xs text-slate-400 mt-1">Ingresos menos egresos del mes</p>
    </div>

    <div class="metric-card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Cotizaciones abiertas</span>
            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-900 metric-value"><?= e($openQuotes) ?></p>
        <p class="text-xs text-slate-400 mt-1">Pipeline <?= money($pipeline) ?></p>
    </div>

    <div class="metric-card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Próximos eventos</span>
            <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-900 metric-value"><?= e($upcomingEventsCount) ?></p>
        <p class="text-xs text-slate-400 mt-1"><?= e($closedDeals) ?> tratos cerrados</p>
    </div>

</div>

<!-- ── Content grid ─────────────────────────────────────── -->
<div class="grid grid-cols-5 gap-6">

    <!-- Recent quotes -->
    <div class="col-span-3 card">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
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
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Evento</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach (array_slice($latestQuotes, 0, 6) as $q): ?>
                    <tr>
                        <td class="font-mono text-xs text-slate-500"><?= e($q['code']) ?></td>
                        <td class="font-medium text-slate-900"><?= e($q['client_name']) ?></td>
                        <td class="text-slate-600"><?= e($q['event_name']) ?></td>
                        <td class="font-semibold text-slate-900"><?= money($q['total']) ?></td>
                        <td><?= statusBadge($q['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Upcoming events -->
    <div class="col-span-2 card">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-900">Agenda próxima</h2>
                <p class="text-xs text-slate-400 mt-0.5">Eventos confirmados y programados</p>
            </div>
            <a href="/eventos" class="btn-ghost text-xs">Ver agenda →</a>
        </div>
        <div class="p-6 space-y-5">
            <?php if (empty($upcomingEvents)): ?>
                <p class="text-slate-400 text-sm text-center py-8">Sin eventos próximos</p>
            <?php endif; ?>
            <?php foreach (array_slice($upcomingEvents, 0, 5) as $ev): ?>
                <div class="flex items-start gap-4">
                    <div class="date-box shrink-0">
                        <span class="date-box-day"><?= e(date('d', strtotime($ev['event_date']))) ?></span>
                        <span class="date-box-month"><?= e(date('M', strtotime($ev['event_date']))) ?></span>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-900 text-sm truncate"><?= e($ev['name']) ?></p>
                        <p class="text-slate-500 text-xs mt-0.5 truncate"><?= e($ev['client_name']) ?></p>
                        <p class="text-slate-400 text-xs"><?= e($ev['city']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
