<!-- ── Page header ──────────────────────────────────────── -->
<div class="flex items-start justify-between gap-6 mb-8">
    <div>
        <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-1">Inventario comercial</p>
        <h1 class="text-3xl font-bold text-slate-900">Servicios</h1>
        <p class="text-slate-500 text-sm mt-1">Catálogo de servicios, precios y disponibilidad</p>
    </div>
    <div class="pt-1 shrink-0">
        <button data-open-modal="serviceModal" class="btn-primary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo servicio
        </button>
    </div>
</div>

<!-- ── Services grid ────────────────────────────────────── -->
<?php if (empty($services)): ?>
    <div class="card flex flex-col items-center justify-center py-20 text-center">
        <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
        <p class="text-slate-400 text-sm">Sin servicios registrados</p>
        <button data-open-modal="serviceModal" class="btn-primary text-sm mt-4">Agregar primer servicio</button>
    </div>
<?php else: ?>
<div class="grid grid-cols-2 gap-5 xl:grid-cols-3 2xl:grid-cols-4">
    <?php foreach ($services as $svc): ?>
        <?php $margin = (float)$svc['price'] > 0 ? (($svc['price'] - $svc['cost']) / $svc['price']) * 100 : 0; ?>
        <div class="card p-5 flex flex-col gap-4 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between gap-2">
                <span class="badge badge-indigo"><?= e($svc['category']) ?></span>
                <?= statusBadge($svc['status']) ?>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-slate-900 text-base"><?= e($svc['name']) ?></h3>
                <p class="text-slate-500 text-sm mt-1 leading-relaxed line-clamp-2"><?= e($svc['description']) ?></p>
            </div>
            <div class="pt-3 border-t border-slate-100">
                <div class="flex items-end justify-between mb-3">
                    <div>
                        <p class="text-2xl font-bold text-slate-900"><?= money($svc['price']) ?></p>
                        <p class="text-xs text-slate-400">por <?= e($svc['billing_unit']) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold <?= $margin >= 40 ? 'text-emerald-600' : ($margin >= 20 ? 'text-amber-600' : 'text-red-500') ?>"><?= number_format($margin, 1, ',', '.') ?>% margen</p>
                        <p class="text-xs text-slate-400">Costo <?= money($svc['cost']) ?></p>
                    </div>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: <?= min(100, max(0, $margin)) ?>%; background: <?= $margin >= 40 ? 'linear-gradient(90deg,#10b981,#059669)' : ($margin >= 20 ? 'linear-gradient(90deg,#f59e0b,#d97706)' : 'linear-gradient(90deg,#ef4444,#dc2626)') ?>"></div>
                </div>
                <div class="flex items-center justify-between mt-3">
                    <span class="text-xs text-slate-500"><?= e($svc['capacity']) ?> cupos</span>
                    <a class="btn-ghost text-xs" href="/servicios/editar?id=<?= e($svc['id']) ?>">Editar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ── Modal: create / edit ────────────────────────────── -->
<dialog id="serviceModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div>
                <h2 class="modal-title"><?= e($formTitle) ?></h2>
                <p class="modal-subtitle">Precio, costo, capacidad y unidad de facturación</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('serviceModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($service !== null): ?><input type="hidden" name="id" value="<?= e($service['id']) ?>"><?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">
                    <label>
                        <span class="form-label">Nombre del servicio <span class="text-red-400">*</span></span>
                        <input class="form-input" name="name" value="<?= e($service['name'] ?? '') ?>" required placeholder="Ej. Inflable gigante">
                    </label>

                    <label>
                        <span class="form-label">Categoría <span class="text-red-400">*</span></span>
                        <input class="form-input" name="category" value="<?= e($service['category'] ?? '') ?>" required placeholder="Atracciones, shows, recreación">
                    </label>

                    <label>
                        <span class="form-label">Unidad de facturación</span>
                        <select class="form-select" name="billing_unit">
                            <?php foreach (['hora' => 'Por hora', 'dia' => 'Por día', 'evento' => 'Por evento', 'persona' => 'Por persona'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($service['billing_unit'] ?? 'evento') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Estado</span>
                        <select class="form-select" name="status">
                            <?php foreach (['disponible' => 'Disponible', 'alta_demanda' => 'Alta demanda', 'mantenimiento' => 'Mantenimiento'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($service['status'] ?? 'disponible') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Precio de venta <span class="text-red-400">*</span></span>
                        <input class="form-input" name="price" type="number" min="0" step="1000" value="<?= e($service['price'] ?? '') ?>" required placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">Costo interno</span>
                        <input class="form-input" name="cost" type="number" min="0" step="1000" value="<?= e($service['cost'] ?? '') ?>" placeholder="0">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Capacidad (personas/unidades)</span>
                        <input class="form-input" name="capacity" type="number" min="1" value="<?= e($service['capacity'] ?? 1) ?>">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Descripción</span>
                        <textarea class="form-textarea" name="description" placeholder="Descripción del servicio, incluye, condiciones…"><?= e($service['description'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($service !== null): ?>
                    <a class="btn-secondary text-sm" href="/servicios">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary text-sm"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($service !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('serviceModal'));</script>
<?php endif; ?>
