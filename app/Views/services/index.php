<section class="section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Inventario comercial</p>
            <h1>Servicios</h1>
        </div>
    </div>

    <div class="grid-two">
        <form class="panel form-grid" method="post" action="<?= e($formAction) ?>">
            <h2><?= e($formTitle) ?></h2>
            <?php if ($service !== null): ?><input type="hidden" name="id" value="<?= e($service['id']) ?>"><?php endif; ?>
            <label>Nombre <input name="name" value="<?= e($service['name'] ?? '') ?>" required></label>
            <label>Categoria <input name="category" value="<?= e($service['category'] ?? '') ?>" placeholder="Atracciones, shows, recreacion" required></label>
            <label>Unidad
                <select name="billing_unit">
                    <?php foreach (['hora' => 'Hora', 'dia' => 'Dia', 'evento' => 'Evento', 'persona' => 'Persona'] as $value => $label): ?><option value="<?= e($value) ?>" <?= ($service['billing_unit'] ?? 'evento') === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label>Precio <input name="price" type="number" min="0" step="1000" value="<?= e($service['price'] ?? '') ?>" required></label>
            <label>Costo <input name="cost" type="number" min="0" step="1000" value="<?= e($service['cost'] ?? '') ?>"></label>
            <label>Capacidad <input name="capacity" type="number" min="1" value="<?= e($service['capacity'] ?? 1) ?>"></label>
            <label>Estado
                <select name="status">
                    <?php foreach (['disponible' => 'Disponible', 'alta_demanda' => 'Alta demanda', 'mantenimiento' => 'Mantenimiento'] as $value => $label): ?><option value="<?= e($value) ?>" <?= ($service['status'] ?? 'disponible') === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="span-2">Descripcion <textarea name="description"><?= e($service['description'] ?? '') ?></textarea></label>
            <button class="primary-btn"><?= e($submitLabel) ?></button>
            <?php if ($service !== null): ?><a class="secondary-btn span-2" href="/servicios">Cancelar edicion</a><?php endif; ?>
        </form>

        <div class="service-grid">
            <?php foreach ($services as $service): ?>
                <?php $margin = (float) $service['price'] > 0 ? (($service['price'] - $service['cost']) / $service['price']) * 100 : 0; ?>
                <article class="service-card">
                    <div>
                        <span class="pill"><?= e($service['category']) ?></span>
                        <h2><?= e($service['name']) ?></h2>
                        <p><?= e($service['description']) ?></p>
                    </div>
                    <div class="service-meta">
                        <strong><?= money($service['price']) ?></strong>
                        <span>Margen <?= e(number_format($margin, 1, ',', '.')) ?>%</span>
                    </div>
                    <footer><span><?= e($service['billing_unit']) ?> - <?= e($service['capacity']) ?> cupos</span><a class="text-btn" href="/servicios/editar?id=<?= e($service['id']) ?>">Editar</a><span class="status"><?= e($service['status']) ?></span></footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
