<section class="section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Inventario comercial</p>
            <h1>Servicios</h1>
        </div>
    </div>

    <div class="grid-two">
        <form class="panel form-grid" method="post" action="/servicios">
            <h2>Crear servicio</h2>
            <label>Nombre <input name="name" required></label>
            <label>Categoria <input name="category" placeholder="Atracciones, shows, recreacion" required></label>
            <label>Unidad
                <select name="billing_unit"><option value="hora">Hora</option><option value="dia">Dia</option><option value="evento">Evento</option><option value="persona">Persona</option></select>
            </label>
            <label>Precio <input name="price" type="number" min="0" step="1000" required></label>
            <label>Costo <input name="cost" type="number" min="0" step="1000"></label>
            <label>Capacidad <input name="capacity" type="number" min="1" value="1"></label>
            <label>Estado
                <select name="status"><option value="disponible">Disponible</option><option value="alta_demanda">Alta demanda</option><option value="mantenimiento">Mantenimiento</option></select>
            </label>
            <label class="span-2">Descripcion <textarea name="description"></textarea></label>
            <button class="primary-btn">Guardar servicio</button>
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
                    <footer><span><?= e($service['billing_unit']) ?> - <?= e($service['capacity']) ?> cupos</span><span class="status"><?= e($service['status']) ?></span></footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
