<section class="section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Operacion</p>
            <h1>Eventos</h1>
        </div>
    </div>

    <div class="grid-two">
        <form class="panel form-grid" method="post" action="<?= e($formAction) ?>">
            <h2><?= e($formTitle) ?></h2>
            <?php if ($event !== null): ?><input type="hidden" name="id" value="<?= e($event['id']) ?>"><?php endif; ?>
            <label>Cliente
                <select name="client_id" required>
                    <?php foreach ($clients as $client): ?><option value="<?= e($client['id']) ?>" <?= (int) ($event['client_id'] ?? 0) === (int) $client['id'] ? 'selected' : '' ?>><?= e($client['name']) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label>Cotizacion relacionada
                <select name="quote_id"><option value="">Sin relacionar</option><?php foreach ($quotes as $quote): ?><option value="<?= e($quote['id']) ?>" <?= (int) ($event['quote_id'] ?? 0) === (int) $quote['id'] ? 'selected' : '' ?>><?= e($quote['code']) ?> - <?= e($quote['event_name']) ?></option><?php endforeach; ?></select>
            </label>
            <label>Nombre <input name="name" value="<?= e($event['name'] ?? '') ?>" required></label>
            <label>Fecha <input name="event_date" type="date" value="<?= e($event['event_date'] ?? '') ?>" required></label>
            <label>Hora inicio <input name="start_time" type="time" value="<?= e(isset($event['start_time']) ? substr((string) $event['start_time'], 0, 5) : '') ?>"></label>
            <label>Hora fin <input name="end_time" type="time" value="<?= e(isset($event['end_time']) ? substr((string) $event['end_time'], 0, 5) : '') ?>"></label>
            <label>Lugar <input name="venue" value="<?= e($event['venue'] ?? '') ?>"></label>
            <label>Ciudad <input name="city" value="<?= e($event['city'] ?? '') ?>"></label>
            <label>Margen esperado % <input name="expected_margin" type="number" min="0" max="100" step="0.1" value="<?= e($event['expected_margin'] ?? '') ?>"></label>
            <label>Estado
                <select name="status">
                    <?php foreach (['programado' => 'Programado', 'confirmado' => 'Confirmado', 'en_ejecucion' => 'En ejecucion', 'finalizado' => 'Finalizado', 'cancelado' => 'Cancelado'] as $value => $label): ?><option value="<?= e($value) ?>" <?= ($event['status'] ?? 'programado') === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="span-2">Equipo <textarea name="team_notes"><?= e($event['team_notes'] ?? '') ?></textarea></label>
            <label class="span-2">Logistica <textarea name="logistics_notes"><?= e($event['logistics_notes'] ?? '') ?></textarea></label>
            <button class="primary-btn"><?= e($submitLabel) ?></button>
            <?php if ($event !== null): ?><a class="secondary-btn span-2" href="/eventos">Cancelar edicion</a><?php endif; ?>
        </form>

        <div class="event-list">
            <?php foreach ($events as $event): ?>
                <?php
                $start = date('Ymd\THis', strtotime($event['event_date'] . ' ' . ($event['start_time'] ?: '08:00')));
                $end = date('Ymd\THis', strtotime($event['event_date'] . ' ' . ($event['end_time'] ?: '17:00')));
                $calendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                    . '&text=' . rawurlencode($event['name'])
                    . '&dates=' . $start . '/' . $end
                    . '&details=' . rawurlencode('Cliente: ' . $event['client_name'] . "\nCotizacion: " . ($event['quote_code'] ?? 'Sin relacionar') . "\nEquipo: " . $event['team_notes'])
                    . '&location=' . rawurlencode($event['venue'] . ', ' . $event['city']);
                ?>
                <article class="event-row">
                    <div class="date-box"><strong><?= e(date('d', strtotime($event['event_date']))) ?></strong><span><?= e(strtoupper(date('M', strtotime($event['event_date'])))) ?></span></div>
                    <div class="event-main">
                        <h2><?= e($event['name']) ?></h2>
                        <p><?= e($event['client_name']) ?> - <?= e($event['venue']) ?>, <?= e($event['city']) ?></p>
                        <div class="event-tags"><span><?= e($event['quote_code'] ?? 'Sin cotizacion') ?></span><span>Margen <?= e($event['expected_margin']) ?>%</span><span><?= e($event['status']) ?></span></div>
                    </div>
                    <div class="event-actions">
                        <a class="text-btn" href="/eventos/editar?id=<?= e($event['id']) ?>">Editar</a>
                        <a class="secondary-btn" href="<?= e($calendarUrl) ?>" target="_blank" rel="noopener">Google Calendar</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
