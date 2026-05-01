<section class="section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Ventas</p>
            <h1>Cotizaciones</h1>
        </div>
    </div>

    <div class="grid-two">
        <form class="panel form-grid" method="post" action="<?= e($formAction) ?>">
            <h2><?= e($formTitle) ?></h2>
            <?php if ($quote !== null): ?><input type="hidden" name="id" value="<?= e($quote['id']) ?>"><?php endif; ?>
            <label>Cliente
                <select name="client_id" required>
                    <?php foreach ($clients as $client): ?><option value="<?= e($client['id']) ?>" <?= (int) ($quote['client_id'] ?? 0) === (int) $client['id'] ? 'selected' : '' ?>><?= e($client['name']) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label>Codigo <input name="code" value="<?= e($quote['code'] ?? ('COT-' . date('YmdHis'))) ?>"></label>
            <label>Evento <input name="event_name" value="<?= e($quote['event_name'] ?? '') ?>" required></label>
            <label>Fecha evento <input name="event_date" type="date" value="<?= e($quote['event_date'] ?? '') ?>"></label>
            <label>Subtotal <input name="subtotal" type="number" min="0" step="1000" value="<?= e($quote['subtotal'] ?? '') ?>" required></label>
            <label>Descuento <input name="discount" type="number" min="0" step="1000" value="<?= e($quote['discount'] ?? 0) ?>"></label>
            <label>Estado
                <select name="status">
                    <?php foreach (['borrador' => 'Borrador', 'enviada' => 'Enviada', 'negociacion' => 'Negociacion', 'aprobada' => 'Aprobada', 'perdida' => 'Perdida'] as $value => $label): ?><option value="<?= e($value) ?>" <?= ($quote['status'] ?? 'borrador') === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label>Probabilidad <input name="probability" type="number" min="0" max="100" value="<?= e($quote['probability'] ?? 50) ?>"></label>
            <label>Valida hasta <input name="valid_until" type="date" value="<?= e($quote['valid_until'] ?? '') ?>"></label>
            <label class="span-2">Notas <textarea name="notes"><?= e($quote['notes'] ?? '') ?></textarea></label>
            <button class="primary-btn"><?= e($submitLabel) ?></button>
            <?php if ($quote !== null): ?><a class="secondary-btn span-2" href="/cotizaciones">Cancelar edicion</a><?php endif; ?>
        </form>

        <div class="quote-board">
            <?php foreach ($quotes as $quote): ?>
                <article class="quote-card">
                    <div class="quote-top"><span><?= e($quote['code']) ?></span><strong><?= e($quote['status']) ?></strong></div>
                    <h2><?= e($quote['event_name']) ?></h2>
                    <p><?= e($quote['client_name']) ?> - <?= e($quote['event_date']) ?></p>
                    <div class="progress"><span style="width: <?= e($quote['probability']) ?>%"></span></div>
                    <footer><strong><?= money($quote['total']) ?></strong><a class="text-btn" href="/cotizaciones/editar?id=<?= e($quote['id']) ?>">Editar</a><span><?= e($quote['probability']) ?>%</span></footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
