<header class="topbar">
    <div>
        <p class="eyebrow">Dashboard ejecutivo</p>
        <h1>Control central para empresas de eventos de recreacion.</h1>
    </div>
    <div class="topbar-actions">
        <a class="secondary-btn" href="/clientes">Nuevo cliente</a>
        <a class="primary-btn" href="/eventos">Programar evento</a>
    </div>
</header>

<section class="section">
    <div class="metric-grid">
        <article class="metric"><span>Ingresos del mes</span><strong><?= money($monthlyRevenue) ?></strong><small>Base contable en MySQL</small></article>
        <article class="metric"><span>Utilidad estimada</span><strong><?= money($monthlyRevenue - $monthlyCosts) ?></strong><small>Ingresos menos egresos del mes</small></article>
        <article class="metric"><span>Cotizaciones abiertas</span><strong><?= e($openQuotes) ?></strong><small>Pipeline <?= money($pipeline) ?></small></article>
        <article class="metric"><span>Proximos eventos</span><strong><?= e($upcomingEventsCount) ?></strong><small><?= e($closedDeals) ?> tratos cerrados</small></article>
    </div>

    <div class="dashboard-grid">
        <article class="panel">
            <div class="panel-header">
                <h2>Cotizaciones recientes</h2>
                <a href="/cotizaciones">Ver ventas</a>
            </div>
            <div class="table-wrap compact">
                <table>
                    <thead><tr><th>Codigo</th><th>Cliente</th><th>Evento</th><th>Total</th><th>Estado</th></tr></thead>
                    <tbody>
                    <?php foreach (array_slice($latestQuotes, 0, 6) as $quote): ?>
                        <tr>
                            <td><?= e($quote['code']) ?></td>
                            <td><?= e($quote['client_name']) ?></td>
                            <td><?= e($quote['event_name']) ?></td>
                            <td><?= money($quote['total']) ?></td>
                            <td><span class="status"><?= e($quote['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </article>

        <article class="panel">
            <div class="panel-header">
                <h2>Agenda proxima</h2>
                <a href="/eventos">Ver eventos</a>
            </div>
            <div class="timeline">
                <?php foreach (array_slice($upcomingEvents, 0, 5) as $event): ?>
                    <div class="timeline-item">
                        <time><?= e(date('d M', strtotime($event['event_date']))) ?></time>
                        <div>
                            <strong><?= e($event['name']) ?></strong>
                            <span><?= e($event['client_name']) ?> - <?= e($event['city']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>
    </div>
</section>
