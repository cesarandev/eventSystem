<section class="section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Ventas</p>
            <h1>Cotizaciones</h1>
        </div>
    </div>

    <div class="grid-two">
        <form class="panel form-grid" method="post" action="/cotizaciones">
            <h2>Crear cotizacion</h2>
            <label>Cliente
                <select name="client_id" required>
                    <?php foreach ($clients as $client): ?><option value="<?= e($client['id']) ?>"><?= e($client['name']) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label>Codigo <input name="code" value="COT-<?= e(date('YmdHis')) ?>"></label>
            <label>Evento <input name="event_name" required></label>
            <label>Fecha evento <input name="event_date" type="date"></label>
            <label>Subtotal <input name="subtotal" type="number" min="0" step="1000" required></label>
            <label>Descuento <input name="discount" type="number" min="0" step="1000" value="0"></label>
            <label>Estado
                <select name="status"><option value="borrador">Borrador</option><option value="enviada">Enviada</option><option value="negociacion">Negociacion</option><option value="aprobada">Aprobada</option><option value="perdida">Perdida</option></select>
            </label>
            <label>Probabilidad <input name="probability" type="number" min="0" max="100" value="50"></label>
            <label>Valida hasta <input name="valid_until" type="date"></label>
            <label class="span-2">Notas <textarea name="notes"></textarea></label>
            <button class="primary-btn">Guardar cotizacion</button>
        </form>

        <div class="quote-board">
            <?php foreach ($quotes as $quote): ?>
                <article class="quote-card">
                    <div class="quote-top"><span><?= e($quote['code']) ?></span><strong><?= e($quote['status']) ?></strong></div>
                    <h2><?= e($quote['event_name']) ?></h2>
                    <p><?= e($quote['client_name']) ?> - <?= e($quote['event_date']) ?></p>
                    <div class="progress"><span style="width: <?= e($quote['probability']) ?>%"></span></div>
                    <footer><strong><?= money($quote['total']) ?></strong><span><?= e($quote['probability']) ?>%</span></footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
